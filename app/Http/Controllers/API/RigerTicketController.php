<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiggerTicket;
use App\Models\RiggerTicketImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;


class RigerTicketController extends Controller
{
    public function add_rigger_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'specifications_remarks' => 'required|string',
            'customer_name' => 'required|string|max:100',
            'location' => 'required|string',
            'po_number' => 'required|string|max:20',
            'date' => 'required|date',
            'leave_yard' => 'required|string',
            'start_job' => 'required|string|max:255',
            'finish_job' => 'required|string|max:255',
            'arrival_yard' => 'required|string|max:255',
            'lunch' => 'required|string|max:255',
            'travel_time' => 'required|string|max:255',
            'crane_time' => 'required|string|max:255',
            'total_hours' => 'required|string|max:255',
            'crane_number' => 'required|string|max:255',
            'rating' => 'required|string|max:255',
            'boom_length' => 'required|string|max:255',
            'operator' => 'required|string|max:100',
            'other_equipment' => 'required|string|max:255',
            'email' => 'required|string|email|max:100',
            'notes' => 'required|string',
            // 'signature' => 'required|string',
            'status' => 'required',
            // 'site_images' => 'required',
            'site_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'created_by' => 'required|integer',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {

            $ticket = new RiggerTicket;
            $ticket->user_id = $request->user_id;
            $ticket->specifications_remarks = $request->specifications_remarks;
            $ticket->customer_name = $request->customer_name;
            $ticket->location = $request->location;
            $ticket->po_number = $request->po_number;
            $ticket->date = $request->date;
            $ticket->leave_yard = $request->leave_yard;
            $ticket->start_job = $request->start_job;
            $ticket->finish_job = $request->finish_job;
            $ticket->arrival_yard = $request->arrival_yard;
            $ticket->lunch = $request->lunch;
            $ticket->travel_time = $request->travel_time;
            $ticket->crane_time = $request->crane_time;
            $ticket->total_hours = $request->total_hours;
            $ticket->crane_number = $request->crane_number;
            $ticket->rating = $request->rating;
            $ticket->boom_length = $request->boom_length;
            $ticket->operator = $request->operator;
            $ticket->other_equipment = $request->other_equipment;
            $ticket->email = $request->email;
            $ticket->notes = $request->notes;
            // $ticket->signature = $request->signature;
            $ticket->status = $request->status;
            $ticket->created_by = $request->created_by;
            $ticket->save();

            if ($request->hasFile('signature')) {

                $path = '/uploads/rigger_tickets_images/' . $ticket->id . '/signature';
                $uploadedFile = $request->file('signature');
                $savedFile = saveSingleImage($uploadedFile, $path);
                $full_path = url('/public/') . $savedFile;
                $ticket->signature = $full_path;
                $ticket->save();
            }
            
            $req_file = 'site_images';
            $path = '/uploads/rigger_tickets_images/' . $ticket->id .'/site';

            if ($request->hasFile($req_file)) {

                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true);
                }
                
                $uploadedFiles = $request->file($req_file);

                foreach ($uploadedFiles as $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $date_append = Str::random(32);
                    $file->move(public_path($path), $date_append . '.' . $file_extension);
    
                    $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

                    $RiggerTicketImages = new RiggerTicketImages();
                    $RiggerTicketImages->ticket_id = $ticket->id;
                    $RiggerTicketImages->file_name = $file->getClientOriginalName();
                    $RiggerTicketImages->path = $savedFilePaths;
                    $RiggerTicketImages->save();
                }
            }
            
    
            return response()->json([
                'success' => true,
                'message' => 'Rigger ticket added successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding rigger ticket: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function update_rigger_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'specifications_remarks' => 'required|string',
            'customer_name' => 'required|string|max:100',
            'location' => 'required|string',
            'po_number' => 'required|string|max:20',
            'date' => 'required|date',
            'leave_yard' => 'required|string',
            'start_job' => 'required|string|max:255',
            'finish_job' => 'required|string|max:255',
            'arrival_yard' => 'required|string|max:255',
            'lunch' => 'required|string|max:255',
            'travel_time' => 'required|string|max:255',
            'crane_time' => 'required|string|max:255',
            'total_hours' => 'required|string|max:255',
            'crane_number' => 'required|string|max:255',
            'rating' => 'required|string|max:255',
            'boom_length' => 'required|string|max:255',
            'operator' => 'required|string|max:100',
            'other_equipment' => 'required|string|max:255',
            'email' => 'required|string|email|max:100',
            'notes' => 'required|string',
            // 'signature' => 'required|string',
            'status' => 'required',
            // 'site_images' => 'required',
            'site_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'created_by' => 'required|integer',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {

            $ticket = RiggerTicket::where('id',$request->ticket_id)->first();
            if($ticket){
                $ticket->specifications_remarks = $request->specifications_remarks;
                $ticket->customer_name = $request->customer_name;
                $ticket->location = $request->location;
                $ticket->po_number = $request->po_number;
                $ticket->date = $request->date;
                $ticket->leave_yard = $request->leave_yard;
                $ticket->start_job = $request->start_job;
                $ticket->finish_job = $request->finish_job;
                $ticket->arrival_yard = $request->arrival_yard;
                $ticket->lunch = $request->lunch;
                $ticket->travel_time = $request->travel_time;
                $ticket->crane_time = $request->crane_time;
                $ticket->total_hours = $request->total_hours;
                $ticket->crane_number = $request->crane_number;
                $ticket->rating = $request->rating;
                $ticket->boom_length = $request->boom_length;
                $ticket->operator = $request->operator;
                $ticket->other_equipment = $request->other_equipment;
                $ticket->email = $request->email;
                $ticket->notes = $request->notes;
                $ticket->status = $request->status;
                $ticket->created_by = $request->created_by;
                $ticket->save();

                if ($request->hasFile('signature')) {

                    $path = '/uploads/rigger_tickets_images/' . $ticket->id . '/signature';
                    $uploadedFile = $request->file('signature');
                    $savedFile = saveSingleImage($uploadedFile, $path);
                    $full_path = url('/public/') . $savedFile;
                    $ticket->signature = $full_path;
                    $ticket->save();
                }
                
                $req_file = 'site_images';
                $path = '/uploads/rigger_tickets_images/' . $ticket->id .'/site';
    
                if ($request->hasFile($req_file)) {
                    
                    $previous_images = RiggerTicketImages::where('ticket_id', $ticket->id)->get();
                    if(count($previous_images) > 0){
                        foreach($previous_images as $img){
                            $del_path = str_replace(url('/public/'), '', $img->path);
                            deleteImage($del_path);
                            RiggerTicketImages::where('id', $img->id)->delete();
                        }
                    }
    
                    if (!File::isDirectory(public_path($path))) {
                        File::makeDirectory(public_path($path), 0777, true);
                    }
                    
                    $uploadedFiles = $request->file($req_file);
    
                    foreach ($uploadedFiles as $file) {
                        $file_extension = $file->getClientOriginalExtension();
                        $date_append = Str::random(32);
                        $file->move(public_path($path), $date_append . '.' . $file_extension);
        
                        $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;
    
                        $RiggerTicketImages = new RiggerTicketImages();
                        $RiggerTicketImages->ticket_id = $ticket->id;
                        $RiggerTicketImages->file_name = $file->getClientOriginalName();
                        $RiggerTicketImages->path = $savedFilePaths;
                        $RiggerTicketImages->save();
                    }
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Rigger ticket updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding rigger ticket: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getTicketList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $tickets = RiggerTicket::where('user_id', $request->user_id)->with(['ticketImages'])->get();
            if($tickets) {
            return response()->json([
                'success' => true,
                'ticket_list' => $tickets,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 401);
        }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getTicketDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $ticket = RiggerTicket::where('id', $request->ticket_id)->with(['ticketImages'])->first();
            if($ticket) {
            return response()->json([
                'success' => true,
                'ticket_detail' => $ticket,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Found',
            ], 401);
        }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function sendtomail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $id = $request->ticket_id;
        $filepath = public_path('assets/pdf/pdf_samples/rigger_ticket.pdf');
        $output_file_path = public_path('assets/pdf/rigger_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = RigerTicket::find($id);
        if($ticket){
            $fields = [
                ['text' => $ticket->id, 'x' => 228, 'y' => 26.8],
                ['text' => $ticket->specifications_remarks, 'x' => 16, 'y' => 75.8],
                ['text' => $ticket->specifications_remarks, 'x' => 144, 'y' => 75.8],
                ['text' => $ticket->customer_name, 'x' => 38, 'y' => 85.1],
                ['text' => $ticket->location, 'x' => 36.5, 'y' => 91.5],
                ['text' => $ticket->date, 'x' => 28, 'y' => 98.2],
                ['text' => $ticket->start_job, 'x' => 40, 'y' => 104.5],
                ['text' => $ticket->finish_job, 'x' => 42, 'y' => 111],
                ['text' => $ticket->crane_number, 'x' => 174, 'y' => 85.1],
                ['text' => $ticket->boom_length, 'x' => 174, 'y' => 91.5],
                ['text' => $ticket->other_equipment, 'x' => 181.5, 'y' => 98.2],
                ['text' => $ticket->crane_number, 'x' => 170, 'y' => 104.5],
                ['text' => $ticket->crane_time, 'x' => 174, 'y' => 111],
                ['text' => $ticket->notes, 'x' => 16, 'y' => 132],
            ];
    
            $this->editPdf($filepath, $output_file_path, $fields);
            return response()->json([
                'success' => true,
                'message' => 'Sent to Admin successfully'
            ], 200);
            
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Rigger Ticket NOt Found',
            ], 401);
        }
        
    }

    public function editPdf($file, $output_file, $fields)
    {
        $fpdi = new Fpdi();
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);

            $fpdi->SetFont('Helvetica', '', 12);
            foreach ($fields as $field) {
                $fpdi->SetXY($field['x'], $field['y']);
                $fpdi->Write(8, $field['text']);
            }
        }

        $fpdi->Output($output_file, 'F');
        sendMail('Admin Team', 'zaidkhurshid525@gmail.com', 'Superior Crane', 'Rigger Ticket Generated', 'Rigger Ticket Generated',$output_file); // send_to_name, send_to_email, email_from_name, subject, body, attachment

        

    }
}
