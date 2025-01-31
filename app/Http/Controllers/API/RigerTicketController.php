<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiggerTicket;
use App\Models\RiggerTicketImages;
use App\Models\JobModel;
use App\Models\User;
use App\Models\Notifications;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;


class RigerTicketController extends Controller
{
    public function add_rigger_ticket(Request $request)
    {   
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'specifications_remarks' => 'nullable|string',
                'customer_name' => 'required|string|max:100',
                'location' => 'required|string',
                'po_number' => 'nullable|string|max:20',
                'date' => 'required|date',
                'leave_yard' => 'required|string',
                'start_job' => 'required|string|max:255',
                'finish_job' => 'required|string|max:255',
                'arrival_yard' => 'required|string|max:255',
                'lunch' => 'nullable|string|max:255',
                'travel_time' => 'nullable|string|max:255',
                'crane_time' => 'nullable|string|max:255',
                'total_hours' => 'nullable|string|max:255',
                'crane_number' => 'nullable|string|max:255',
                'rating' => 'nullable|string|max:255',
                'boom_length' => 'nullable|string|max:255',
                'operator' => 'nullable|string|max:100',
                'other_equipment' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:100',
                'notes' => 'nullable|string',
                'signature' => 'required|string',
                'status' => 'required',
                // 'site_images' => 'required',
                'site_images.*.file' => 'nullable|string',
                'site_images.*.title' => 'nullable|string|max:255',
                'site_images.*.type' => 'nullable|string|max:255',
                // 'site_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'status' => 'required',
                'created_by' => 'required|integer',
            ]);
        }
        
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // try {

            $ticket = new RiggerTicket;
            $ticket->user_id = $request->user_id;
            $ticket->job_id = $request->job_id;
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
            $ticket->status = $request->status;
            $ticket->created_by = $request->created_by;
            $ticket->save();

            if($request->status == '3'){
                JobModel::where('id', $ticket->job_id)->update(['status' => '3']);
            }

            $site_images = $request->site_images;
            if(is_countable($site_images) && count($site_images) > 0){
                
                foreach ($site_images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
                    $type = $imageData['type'];
                    
                    // Decode base64 string
                    $image = str_replace('data:image/jpg;base64,', '', $image);
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace('data:image/pdf;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    
                    if($type == 'image'){
                        $imageName = Str::random(32).'.'.'png';
                    }else{
                        $imageName = Str::random(32).'.'.'pdf';
                    }
                    
                    $filePath = public_path('uploads/rigger_tickets_images/' . $ticket->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $RiggerTicketImages = new RiggerTicketImages();
                    $RiggerTicketImages->ticket_id = $ticket->id;
                    $RiggerTicketImages->path = '/public/uploads/rigger_tickets_images/' . $ticket->id . '/' . $imageName;
                    $RiggerTicketImages->file_name = $title;
                    $RiggerTicketImages->type = $type == 'image' ? 'png' : 'pdf';
                    $RiggerTicketImages->save();
                }
            }
            
            $this->sendEmailRiggerTicket($ticket->id);      // email send when ticket status is 3 completed
    
            return response()->json([
                'success' => true,
                'message' => 'Rigger ticket added successfully',
                'id' => $ticket->id
            ], 200);
        // } catch (\Exception $e) {
        //     // Log the error for debugging purposes
        //     Log::error('Error adding rigger ticket: ' . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => "Oops! Network Error",
        //     ], 500);
        // }
    }

    public function update_rigger_ticket(Request $request)
    {   
        if(isset($request->status) && $request->status == '3'){

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'ticket_id' => 'required',
                'specifications_remarks' => 'nullable|string',
                'customer_name' => 'required|string|max:100',
                'location' => 'required|string',
                'po_number' => 'nullable|string|max:20',
                'date' => 'required|date',
                'leave_yard' => 'required|string',
                'start_job' => 'required|string|max:255',
                'finish_job' => 'required|string|max:255',
                'arrival_yard' => 'required|string|max:255',
                'lunch' => 'nullable|string|max:255',
                'travel_time' => 'nullable|string|max:255',
                'crane_time' => 'nullable|string|max:255',
                'total_hours' => 'nullable|string|max:255',
                'crane_number' => 'nullable|string|max:255',
                'rating' => 'nullable|string|max:255',
                'boom_length' => 'nullable|string|max:255',
                'operator' => 'nullable|string|max:100',
                'other_equipment' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:100',
                'notes' => 'nullable|string',
                'signature' => 'required|string',
                'status' => 'required',
                // 'site_images' => 'required',
                // 'site_images.*.file' => 'required|string',
                // 'site_images.*.title' => 'required|string|max:255',
                // 'site_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'ticket_id' => 'required',
                'status' => 'required',
                'created_by' => 'required|integer',
            ]);
        }
    
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
                $ticket->signature = $request->signature;
                $ticket->status = $request->status;
                $ticket->created_by = $request->created_by;
                $ticket->save();

                if($request->status == '3'){
                    JobModel::where('id', $ticket->job_id)->update(['status' => '3']);
                }

                $this->sendEmailRiggerTicket($ticket->id);      // email send when ticket status is 3 completed
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

    public function addTicketImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'site_images' => 'required',
            'site_images.*.file' => 'required|string',
            'site_images.*.title' => 'required|string|max:255',
            'site_images.*.type' => 'required|string|max:255',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $site_images = $request->site_images;
            if(is_countable($site_images) && count($site_images) > 0){
                
                foreach ($site_images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
                    $type = $imageData['type'];
                    
                    // Decode base64 string
                    $image = str_replace('data:image/jpg;base64,', '', $image);
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace('data:image/pdf;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    
                    if($type == 'image'){
                        $imageName = Str::random(32).'.'.'png';
                    }else{
                        $imageName = Str::random(32).'.'.'pdf';
                    }
                    
                    $filePath = public_path('uploads/rigger_tickets_images/' . $request->ticket_id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $RiggerTicketImages = new RiggerTicketImages();
                    $RiggerTicketImages->ticket_id = $request->ticket_id;
                    $RiggerTicketImages->path = '/public/uploads/rigger_tickets_images/' . $request->ticket_id . '/' . $imageName;
                    $RiggerTicketImages->file_name = $title;
                    $RiggerTicketImages->type = $type == 'image' ? 'png' : 'pdf';
                    $RiggerTicketImages->save();
                }
            }

            $ticket_images = RiggerTicketImages::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'ticket_images' => $ticket_images,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function deleteTicketImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            RiggerTicketImages::where('ticket_id', $request->ticket_id)->where('id', $request->image_id)->delete();

            $ticket_images = RiggerTicketImages::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'ticket_images' => $ticket_images,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
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
            $dateLimit = getApiRecordLimitDate();
            // $tickets = RiggerTicket::where('user_id', $request->user_id)->with(['ticketImages','jobDetail'])->get();
            $tickets = RiggerTicket::whereHas('jobDetail', function ($query) use ($request) {
                                $query->whereJsonContains('rigger_assigned', (string) $request->user_id);
                            })
                            ->with(['ticketImages', 'jobDetail'])
                            ->whereDate('date', '>=', $dateLimit)
                            ->get();
            // $ticketsIds = RiggerTicket::whereHas('jobDetail', function ($query) use ($request) {
            //     $query->whereJsonContains('rigger_assigned', (string) $request->user_id);
            // })
            // ->with(['ticketImages', 'jobDetail'])->pluck('id')->toArray();
            
            if($tickets) {
                return response()->json([
                    'success' => true,
                    // 'ticket_list_ids' => $ticketsIds,
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

    public function sendEmailRiggerTicket($ticket_id){

        $ticketDetail = RiggerTicket::where('id', $ticket_id)->first();
        
        if($ticketDetail->status == '3'){       // if status is (3) completed  then send email
            
            $attachment_pdf = $this->makeRiggerPDF($ticket_id);
            
            if($attachment_pdf){
                

                $riggerDetail = User::where('id', $ticketDetail->created_by)->first(); // created or rigger details

                $jobDetail = JobModel::where('id', $ticketDetail->job_id)->first(); // lnked job details
            
                if($jobDetail){
                    
                    $managerDetail = User::where('id', $jobDetail->created_by)->first(); // manager/ JOB createby details

                    if($ticketDetail->status == '1'){
                        $status_txt = 'Draft';
                    }else if($ticketDetail->status == '2'){
                        $status_txt = 'Issued';
                    }else if($ticketDetail->status == '3'){
                        $status_txt = 'Completed';
                    }else{
                        $status_txt = '';
                    }
                    
                    $mailData = [];
                    
                    $mailData['user'] = $managerDetail->name;
                    $mailData['rigger_name'] = $riggerDetail->name;
                    $mailData['job_number'] = 'J-'.$ticketDetail->job_id;
                    $mailData['rigger_number'] = 'RTKT-'.$ticketDetail->id;
                    $mailData['customer_name'] = $ticketDetail->customer_name;
                    $mailData['location'] = $ticketDetail->location;
                    $mailData['po_number'] = $ticketDetail->po_number;
                    $mailData['ticket_date'] = $ticketDetail->date != null ? date('d-M-Y', strtotime($ticketDetail->date)) : '';
                    $mailData['start_time'] = $ticketDetail->start_job != null ? date('H:i A', strtotime($ticketDetail->start_job)) : '';
                    $mailData['finish_time'] = $ticketDetail->finish_job != null ? date('H:i A', strtotime($ticketDetail->finish_job)) : '';
                    $mailData['status'] = $status_txt;
    
                    $mailData['text1'] = "New Rigger Ticket has been created. Ticket details are as under.";
                    $mailData['text2'] = "For more details please contact the Manager/Admin.";
    
                    $body = view('emails.rigger_ticket_template', $mailData);
                    $userEmailsSend = $managerDetail->email;//'hamza@5dsolutions.ae';//
                    sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Rigger Ticket Creation', $body, $attachment_pdf);
                    
                    if($ticketDetail->email !=  null && $ticketDetail->email != ''){
                        $mailData['user'] = $ticketDetail->customer_name;
                        $body = view('emails.rigger_ticket_template', $mailData);
                        sendMailAttachment($ticketDetail->customer_name, $ticketDetail->email, 'Superior Crane', 'Rigger Ticket Creation', $body, $attachment_pdf);
                    }
                    
                    // push notification entry
                    $Notifications = new Notifications();
                    $Notifications->module_code = 'RIGGER TICKET SUBMITTED';
                    $Notifications->from_user_id = $riggerDetail->id;
                    $Notifications->to_user_id = '1';   // for super admin
                    $Notifications->subject = 'Rigger Ticket Submitted';
                    $Notifications->message = 'Rigger Ticket RTKT-'.$ticketDetail->id.' on '.$ticketDetail->date != null ? date('d-M-Y', strtotime($ticketDetail->date)) : ''.' has been submitted by '.$riggerDetail->name.'.';
                    $Notifications->message_html = $body;
                    $Notifications->read_flag = '0';
                    $Notifications->created_by = $riggerDetail->id;
                    $Notifications->created_at = date('Y-m-d H:i:s');
                    $Notifications->save();

                    $allAdmins = User::whereIn('role_id', ['0','1'])->where('status', '1')->get();

                    if($allAdmins){
                        foreach($allAdmins as $value){
                            $mailData['user'] = $value->name;
                            $body = view('emails.rigger_ticket_template', $mailData);
                            $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                            sendMailAttachment($value->name, $userEmailsSend, 'Superior Crane', 'Rigger Ticket Creation', $body, $attachment_pdf);
                        }
                    }
                }
            }
        }
    }

    public function makeRiggerPDF($ticket_id='')
    {

        $id = $ticket_id;
        $filepath = public_path('assets/pdf/pdf_samples/rigger_ticket.pdf');
        $output_file_path = public_path('assets/pdf/rigger_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = RiggerTicket::find($id);
        if($ticket){
            $fields = [
                ['text' => 'R-'.$ticket->id, 'x' => 245, 'y' => 6.5],
                ['text' => $ticket->specifications_remarks, 'x' => 128, 'y' => 58, 'width' => 138, 'height' => 6],
                
                ['text' => $ticket->customer_name, 'x' => 14, 'y' => 94],
                ['text' => $ticket->location, 'x' => 99, 'y' => 94],
                ['text' => $ticket->po_number, 'x' => 226, 'y' => 94],
                ['text' => $ticket->date != null ? date('d-M-Y', strtotime($ticket->date)) : '', 'x' => 14, 'y' => 106],
                ['text' => $ticket->leave_yard, 'x' => 42, 'y' => 106],
                ['text' => $ticket->start_job, 'x' => 70, 'y' => 106],
                ['text' => $ticket->finish_job, 'x' => 99, 'y' => 106],
                ['text' => $ticket->arrival_yard, 'x' => 127, 'y' => 106],
                ['text' => $ticket->lunch, 'x' => 153.5, 'y' => 106, 'font' => 8],
                ['text' => $ticket->travel_time, 'x' => 183, 'y' => 106],
                ['text' => $ticket->crane_time, 'x' => 211, 'y' => 106],
                ['text' => $ticket->total_hours, 'x' => 239, 'y' => 106],

                ['text' => $ticket->crane_number, 'x' => 14, 'y' => 117.5],
                ['text' => $ticket->rating, 'x' => 42, 'y' => 117.5],
                ['text' => $ticket->boom_length, 'x' => 70, 'y' => 117.5],
                ['text' => $ticket->operator, 'x' => 98, 'y' => 117.5],
                ['text' => $ticket->other_equipment, 'x' => 183, 'y' => 117.5],
                ['text' => $ticket->notes, 'x' => 15, 'y' => 134, 'width' => 250, 'height' => 6],

                // ['text' => $ticket->signature, 'x' => 40, 'y' => 187],
                ['base64_image' => $ticket->signature, 'x' => 55, 'y' => 182, 'width' => 30, 'height' => 14.5],

            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            return $outputFile;//'/public'.
            
        }else{
            return false;
        }
        
    }

    // public function editPdf($file, $output_file, $fields)
    // {
    //     $fpdi = new Fpdi();
    //     $count = $fpdi->setSourceFile($file);

    //     for ($i = 1; $i <= $count; $i++) {
    //         $template = $fpdi->importPage($i);
    //         $size = $fpdi->getTemplateSize($template);
    //         $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
    //         $fpdi->useTemplate($template);

    //         $fpdi->SetFont('Helvetica', '', 10);
    //         foreach ($fields as $field) {
    //             $fpdi->SetXY($field['x'], $field['y']);
                
    //             if(isset($field['base64_image']) ){
    //                 if($field['base64_image'] != '' && $field['base64_image'] != null){
    //                     // Decode the base64 image and save it to a temporary file
    //                     $imageData = base64_decode($field['base64_image']);
    //                     $tempFilePath = tempnam(sys_get_temp_dir(), 'sig_') . '.png';
    //                     file_put_contents($tempFilePath, $imageData);

    //                     // Add the image to the PDF
    //                     $fpdi->Image($tempFilePath, $field['x'], $field['y'], $field['width'], $field['height']);

    //                     // Remove the temporary file
    //                     unlink($tempFilePath);   
    //                 }else{
    //                     $fpdi->Write(8, '');
    //                 }
                     

    //             }else{

    //                 if(isset($field['font'])){
    //                     $fpdi->SetFont('Helvetica', '', $field['font']);
    //                 }else{
    //                     $fpdi->SetFont('Helvetica', '', 10);
    //                 }
                    
    //                 if (isset($field['width']) && isset($field['height'])) {
    //                     $fpdi->MultiCell($field['width'], $field['height'], isset($field['text']) ? $field['text'] : '');
    //                 } else {
    //                     $fpdi->Write(8, isset($field['text']) ? $field['text'] : '');
    //                 }
    //             }
    //         }
    //     }

    //     $fpdi->Output($output_file, 'F');
        
    //     return $output_file;
    // }

    public function editPdf($file, $output_file, $fields)
    {
        $fpdi = new Fpdi();
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);

            $fpdi->SetFont('Helvetica', '', 10);
            foreach ($fields as $field) {
                $fpdi->SetXY($field['x'], $field['y']);

                if(isset($field['base64_image'])){
                    if($field['base64_image'] != '' && $field['base64_image'] != null){
                        // Decode the base64 image
                        $imageData = base64_decode($field['base64_image']);
                        $image = imagecreatefromstring($imageData);
                
                        // Convert the image to 8-bit or 24-bit format
                        if ($image !== false) {
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'sig_') . '.png';
                            
                            // Save the image in 24-bit format
                            imagepng($image, $tempFilePath);
                            imagedestroy($image);
                
                            // Add the image to the PDF
                            $fpdi->Image($tempFilePath, $field['x'], $field['y'], $field['width'], $field['height']);
                
                            // Remove the temporary file
                            unlink($tempFilePath);
                        } else {
                            throw new Exception('Invalid image data');
                        }
                    } else {
                        $fpdi->Write(8, '');
                    }
                }else{

                    if(isset($field['font'])){
                        $fpdi->SetFont('Helvetica', '', $field['font']);
                    }else{
                        $fpdi->SetFont('Helvetica', '', 10);
                    }
                    
                    if (isset($field['width']) && isset($field['height'])) {
                        $fpdi->MultiCell($field['width'], $field['height'], isset($field['text']) ? $field['text'] : '');
                    } else {
                        $fpdi->Write(8, isset($field['text']) ? $field['text'] : '');
                    }
                }
            }
        }
        $fpdi->Output($output_file, 'F');
        return $output_file;
    }

    public function getTicketsForPayduty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $dateLimit = getApiRecordLimitDate();
            $tickets = RiggerTicket::where('user_id', $request->user_id)->where('status', '3')
                            ->whereDoesntHave('payDuty')
                            ->whereDate('date', '>=', $dateLimit)->get();

            if(is_countable($tickets) && count($tickets) > 0) {
                $tickets_list_new = [];

                foreach($tickets as $ticket){
                    $jobAddress = JobModel::where('id', $ticket->job_id)->value('address');
                    if($jobAddress){
                        $ticket->ticket_name = 'RTKT-' . $ticket->id . ' | ' . $ticket->customer_name . ' | ' . substr($jobAddress, 0, 12).'...';
                        // $ticket->ticket_name = 'RTKT-' . $ticket->id . ' | ' . $ticket->customer_name . ' | ' . $jobAddress;
                    }else{
                        $ticket->ticket_name = 'RTKT-'.$ticket->id .' | '.$ticket->customer_name;
                    }
                    
                }
                return response()->json([
                    'success' => true,
                    'tickets' => $tickets,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Tickets Found',
                ], 401);
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading jobs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }
}
