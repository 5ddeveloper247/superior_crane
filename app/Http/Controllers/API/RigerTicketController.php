<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RigerTicket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;


class RigerTicketController extends Controller
{
    public function add_rigger_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'signature' => 'required|string',
            'site_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            $ticket = new RigerTicket;
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
            $ticket->signature = $request->signature;
            $ticket->created_by = $request->created_by;
            $ticket->save();

            if ($request->hasFile('site_pic')) {

                $path = '/uploads/rigger_tickets_images/' . $ticket->id;
                $uploadedFile = $request->file('site_pic');
                $savedFile = saveSingleImage($uploadedFile, $path);
                $full_path = url('/public/') . $savedFile;
                $ticket->site_pic = $full_path;
                $ticket->save();
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

    public function sendtomail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'rigger_ticket_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $filepath = public_path('assets/pdf/pdf_samples/rigger_ticket.pdf');
        $id = $request->rigger_ticket_id;
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
