<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobModel;
use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class TransportationTicketController extends Controller
{
    public function add_transportation_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'job_id' => 'required',
            'pickup_address' => 'required|string',
            'delivery_address' => 'required|string',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'notes' => 'required|string',
            'job_number' => 'required|string|max:50',
            'job_special_instructions' => 'required|string',
            'po_number' => 'required|string|max:50',
            'po_special_instructions' => 'required|string',
            'site_contact_name' => 'required|string|max:100',
            'site_name_special_instructions' => 'required|string',
            'site_contact_number' => 'required|string|max:17',
            'site_number_special_instructions' => 'required|string',
            'shipper_name' => 'required|string|max:100',
            // 'shipper_signature' => 'required|string',
            'shipper_signature_date' => 'required|date',
            'shipper_time_in' => 'required|date_format:H:i',
            'shipper_time_out' => 'required|date_format:H:i',
            'pickup_driver_name' => 'required|string|max:100',
            // 'pickup_driver_signature' => 'required|string',
            'pickup_driver_signature_date' => 'required|date',
            'pickup_driver_time_in' => 'required|date_format:H:i',
            'pickup_driver_time_out' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|string|email|max:100',
            // 'customer_signature' => 'required|string',
            'customer_signature_date' => 'required|date',
            'customer_time_in' => 'required|date_format:H:i',
            'customer_time_out' => 'required|date_format:H:i',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $record = new TransportationTicketModel; 
            $record->user_id = $request->user_id;
            $record->job_id = $request->job_id;
            $record->pickup_address = $request->pickup_address;
            $record->delivery_address = $request->delivery_address;
            $record->time_in = $request->time_in;
            $record->time_out = $request->time_out;
            $record->notes = $request->notes;
            $record->job_number = $request->job_number;
            $record->job_special_instructions = $request->job_special_instructions;
            $record->po_number = $request->po_number;
            $record->po_special_instructions = $request->po_special_instructions;
            $record->site_contact_name = $request->site_contact_name;
            $record->site_contact_name_special_instructions = $request->site_name_special_instructions;
            $record->site_contact_number = $request->site_contact_number;
            $record->site_contact_number_special_instructions = $request->site_number_special_instructions;
            $record->shipper_name = $request->shipper_name;
            // $record->shipper_signature = $request->shipper_signature;
            $record->shipper_signature_date = $request->shipper_signature_date;
            $record->shipper_time_in = $request->shipper_time_in;
            $record->shipper_time_out = $request->shipper_time_out;
            $record->pickup_driver_name = $request->pickup_driver_name;
            // $record->pickup_driver_signature = $request->pickup_driver_signature;
            $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
            $record->pickup_driver_time_in = $request->pickup_driver_time_in;
            $record->pickup_driver_time_out = $request->pickup_driver_time_out;
            $record->customer_name = $request->customer_name;
            $record->customer_email = $request->customer_email;
            // $record->customer_signature = $request->customer_signature;
            $record->customer_signature_date = $request->customer_signature_date;
            $record->customer_time_in = $request->customer_time_in;
            $record->customer_time_out = $request->customer_time_out;
            $record->status = $request->status;
            $record->created_by = $request->created_by;
            $record->save();

            if ($request->hasFile('shipper_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/shipper_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->shipper_signature = $full_path;
                $record->save();
            }

            if ($request->hasFile('pickup_driver_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/pickup_driver_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->pickup_driver_signature = $full_path;
                $record->save();
            }

            if ($request->hasFile('customer_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/customer_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->customer_signature = $full_path;
                $record->save();
            }

            $images = $request->images;
            if(count($images) > 0){
                
                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = Str::random(32).'.'.'png';
                    $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $record->id;
                    $TransportationTicketImages->path = 'public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->save();
                }
            }

            $this->sendEmailTransporterTicket($record->id);

            return response()->json([
                'success' => true,
                'message' => 'Transportation Ticket added successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function update_transportation_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'user_id' => 'required',
            'job_id' => 'required',
            'pickup_address' => 'required|string',
            'delivery_address' => 'required|string',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'notes' => 'required|string',
            'job_number' => 'required|string|max:50',
            'job_special_instructions' => 'required|string',
            'po_number' => 'required|string|max:50',
            'po_special_instructions' => 'required|string',
            'site_contact_name' => 'required|string|max:100',
            'site_name_special_instructions' => 'required|string',
            'site_contact_number' => 'required|string|max:17',
            'site_number_special_instructions' => 'required|string',
            'shipper_name' => 'required|string|max:100',
            // 'shipper_signature' => 'required|string',
            'shipper_signature_date' => 'required|date',
            'shipper_time_in' => 'required|date_format:H:i',
            'shipper_time_out' => 'required|date_format:H:i',
            'pickup_driver_name' => 'required|string|max:100',
            // 'pickup_driver_signature' => 'required|string',
            'pickup_driver_signature_date' => 'required|date',
            'pickup_driver_time_in' => 'required|date_format:H:i',
            'pickup_driver_time_out' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|string|email|max:100',
            // 'customer_signature' => 'required|string',
            'customer_signature_date' => 'required|date',
            'customer_time_in' => 'required|date_format:H:i',
            'customer_time_out' => 'required|date_format:H:i',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
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
            $record = TransportationTicketModel::where('id', $request->ticket_id)->first();
            if($record){
                $record->user_id = $request->user_id;
                $record->job_id = $request->job_id;
                $record->pickup_address = $request->pickup_address;
                $record->delivery_address = $request->delivery_address;
                $record->time_in = $request->time_in;
                $record->time_out = $request->time_out;
                $record->notes = $request->notes;
                $record->job_number = $request->job_number;
                $record->job_special_instructions = $request->job_special_instructions;
                $record->po_number = $request->po_number;
                $record->po_special_instructions = $request->po_special_instructions;
                $record->site_contact_name = $request->site_contact_name;
                $record->site_contact_name_special_instructions = $request->site_name_special_instructions;
                $record->site_contact_number = $request->site_contact_number;
                $record->site_contact_number_special_instructions = $request->site_number_special_instructions;
                $record->shipper_name = $request->shipper_name;
                // $record->shipper_signature = $request->shipper_signature;
                $record->shipper_signature_date = $request->shipper_signature_date;
                $record->shipper_time_in = $request->shipper_time_in;
                $record->shipper_time_out = $request->shipper_time_out;
                $record->pickup_driver_name = $request->pickup_driver_name;
                // $record->pickup_driver_signature = $request->pickup_driver_signature;
                $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
                $record->pickup_driver_time_in = $request->pickup_driver_time_in;
                $record->pickup_driver_time_out = $request->pickup_driver_time_out;
                $record->customer_name = $request->customer_name;
                $record->customer_email = $request->customer_email;
                // $record->customer_signature = $request->customer_signature;
                $record->customer_signature_date = $request->customer_signature_date;
                $record->customer_time_in = $request->customer_time_in;
                $record->customer_time_out = $request->customer_time_out;
                $record->status = $request->status;
                $record->created_by = $request->created_by;
                $record->save();

                if ($request->hasFile('shipper_signature')) {

                    $del_path = str_replace(url('/public/'), '', $record->shipper_signature);
                    deleteImage($del_path);

                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/shipper_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->shipper_signature = $full_path;
                    $record->save();
                }

                if ($request->hasFile('pickup_driver_signature')) {
                    
                    $del_path = str_replace(url('/public/'), '', $record->pickup_driver_signature);
                    deleteImage($del_path);
                    
                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/pickup_driver_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->pickup_driver_signature = $full_path;
                    $record->save();
                }

                if ($request->hasFile('customer_signature')) {

                    $del_path = str_replace(url('/public/'), '', $record->customer_signature);
                    deleteImage($del_path);

                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/customer_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->customer_signature = $full_path;
                    $record->save();
                }

                $images = $request->images;
                if(count($images) > 0){
                    
                    $previous_images = TransportationTicketImages::where('ticket_id', $record->id)->get();
                    if(count($previous_images) > 0){
                        foreach($previous_images as $img){
                            $del_path = str_replace(url('/public/'), '', $img->path);
                            deleteImage($del_path);
                            TransportationTicketImages::where('id', $img->id)->delete();
                        }
                    }

                    foreach ($images as $index => $imageData) {
                        $image = $imageData['file'];
                        $title = $imageData['title'];
                
                        // Decode base64 string
                        $image = str_replace('data:image/png;base64,', '', $image);
                        $image = str_replace(' ', '+', $image);
                        $imageName = Str::random(32).'.'.'png';
                        $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
                
                        if (!file_exists($filePath)) {
                            mkdir($filePath, 0777, true);
                        }
                
                        \File::put($filePath . '/' . $imageName, base64_decode($image));
                
                        // Save image path and title to database
                        $TransportationTicketImages = new TransportationTicketImages();
                        $TransportationTicketImages->ticket_id = $record->id;
                        $TransportationTicketImages->path = 'public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                        $TransportationTicketImages->file_name = $title;
                        $TransportationTicketImages->save();
                    }
                }

                $this->sendEmailTransporterTicket($record->id);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Transportation Ticket updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding record: ' . $e->getMessage());
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

            $transportation_ticket_list = TransportationTicketModel::where('user_id', $request->user_id)->with(['ticketImages'])->get();
            
            if($transportation_ticket_list) {
                return response()->json([
                    'success' => true,
                    'ticket_list' => $transportation_ticket_list,
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

            $ticket_detail = TransportationTicketModel::where('id', $request->ticket_id)->with(['ticketImages'])->first();
            if($ticket_detail) {
                return response()->json([
                    'success' => true,
                    'ticket_detail' => $ticket_detail,
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

    public function sendEmailTransporterTicket($ticket_id){

        $attachment_pdf = $this->makeTicketPDF($ticket_id);

        if($attachment_pdf){
            
            $ticketDetail = TransportationTicketModel::where('id', $ticket_id)->first();

            if($ticketDetail->status == '3'){       // if status is (3) completed  then send email
            
                $transporterDetail = User::where('id', $ticketDetail->created_by)->first(); // created or rigger details

                $jobDetail = JobModel::where('id', $ticketDetail->job_id)->first(); // lnked job details
            
                if($jobDetail){
                    
                    $managerDetail = User::where('id', $jobDetail->created_by)->first(); // manager/createby details

                    if($ticketDetail->status == '1'){
                        $status_txt = 'Draft';
                    }else if($ticketDetail->status == '2'){
                        $status_txt = 'Issued';
                    }else if($ticketDetail->status == '3'){
                        $status_txt = 'Completed';
                    }
                    
                    $mailData = [];
                    
                    $mailData['user'] = $managerDetail->name;
                    $mailData['transporter_name'] = $transporterDetail->name;
                    $mailData['job_number'] = 'J-'.$ticketDetail->job_id;
                    $mailData['ticket_number'] = 'T-'.$ticketDetail->id;
                    $mailData['pickup_address'] = $ticketDetail->pickup_address;
                    $mailData['delivery_address'] = $ticketDetail->delivery_address;

                    $mailData['po_number'] = $ticketDetail->po_number;
                    $mailData['ticket_date'] = date('d-M-Y', strtotime($ticketDetail->created_at));
                    $mailData['time_in'] = date('H:i A', strtotime($ticketDetail->time_in));
                    $mailData['time_out'] = date('H:i A', strtotime($ticketDetail->time_out));
                    $mailData['status'] = $status_txt;
    
                    $mailData['text1'] = "New Transporter Ticket has been created. Ticket details are as under.";
                    $mailData['text2'] = "For more details please contact the Manager/Admin.";
    
                    $body = view('emails.transporter_ticket_template', $mailData);
                    $userEmailsSend = 'hamza@5dsolutions.ae';//$managerDetail->email;
                    sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);

                    // push notification entry
                    $Notifications = new Notifications();
                    $Notifications->module_code = 'TRANSPORTER TICKET SUBMITTED';
                    $Notifications->from_user_id = $transporterDetail->id;
                    $Notifications->to_user_id = '1';   // for super admin
                    $Notifications->subject = 'Transporter Ticket Submitted';
                    $Notifications->message = 'Transporter Ticket T-'.$ticketDetail->id.' on '.date('d-M-Y', strtotime($ticketDetail->created_at)).' has been submitted by '.$transporterDetail->name.'.';
                    $Notifications->message_html = $body;
                    $Notifications->read_flag = '0';
                    $Notifications->created_by = $transporterDetail->id;
                    $Notifications->created_at = date('Y-m-d H:i:s');
                    $Notifications->save();
                    
                    $allAdmins = User::whereIn('role_id', ['0','1'])->where('status', '1')->get();

                    if($allAdmins){
                        foreach($allAdmins as $value){
                            $mailData['user'] = $value->name;
                            $body = view('emails.transporter_ticket_template', $mailData);
                            $userEmailsSend = 'hamza@5dsolutions.ae';//$value->email;
                            sendMailAttachment($value->name, $userEmailsSend, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);
                        }
                    }
                }
            }
        }
    }
    public function makeTicketPDF($ticket_id='')
    {

        $id = $ticket_id;
        $filepath = public_path('assets/pdf/pdf_samples/transporter_ticket.pdf');
        $output_file_path = public_path('assets/pdf/transporter_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = TransportationTicketModel::find($id);
        if($ticket){
            $fields = [
                ['text' => 'T-'.$ticket->id, 'x' => 245, 'y' => 13],
                ['text' => $ticket->pickup_address, 'x' => 58, 'y' => 33, 'width' => 210, 'height' => 6],
                ['text' => $ticket->delivery_address, 'x' => 58, 'y' => 41, 'width' => 210, 'height' => 6],
                // ['text' => $ticket->delivery_address, 'x' => 58, 'y' => 49, 'width' => 210, 'height' => 6],
                
                ['text' => $ticket->job_number, 'x' => 58, 'y' => 65],
                ['text' => $ticket->job_special_instructions, 'x' => 105, 'y' => 66, 'width' => 170, 'height' => 6],

                ['text' => $ticket->po_number, 'x' => 58, 'y' => 71],
                ['text' => $ticket->po_special_instructions, 'x' => 105, 'y' => 72, 'width' => 170, 'height' => 6],

                ['text' => $ticket->site_contact_name, 'x' => 58, 'y' => 76],
                ['text' => $ticket->site_contact_name_special_instructions, 'x' => 105, 'y' => 77, 'width' => 170, 'height' => 6],

                ['text' => $ticket->site_contact_number, 'x' => 58, 'y' => 81],
                ['text' => $ticket->site_contact_number_special_instructions, 'x' => 105, 'y' => 82, 'width' => 170, 'height' => 6],


                ['text' => $ticket->shipper_name, 'x' => 58, 'y' => 96.5],
                ['text' => $ticket->shipper_signature, 'x' => 103, 'y' => 96.5],
                ['text' => date('d-M-Y', strtotime($ticket->shipper_signature_date)), 'x' => 164, 'y' => 96.5],
                ['text' => date('H:i', strtotime($ticket->shipper_time_in)), 'x' => 210, 'y' => 96.5],
                ['text' => $ticket->shipper_time_out, 'x' => 241, 'y' => 96.5],

                ['text' => $ticket->pickup_driver_name, 'x' => 58, 'y' => 103],
                ['text' => $ticket->pickup_driver_signature, 'x' => 103, 'y' => 103],
                ['text' => date('d-M-Y', strtotime($ticket->pickup_driver_signature_date)), 'x' => 164, 'y' => 103],
                ['text' => date('H:i', strtotime($ticket->pickup_driver_time_in)), 'x' => 210, 'y' => 103],
                ['text' => $ticket->pickup_driver_time_out, 'x' => 241, 'y' => 103],

                ['text' => $ticket->customer_name, 'x' => 58, 'y' => 110],
                ['text' => $ticket->customer_signature, 'x' => 103, 'y' => 110],
                ['text' => date('d-M-Y', strtotime($ticket->customer_signature_date)), 'x' => 164, 'y' => 110],
                ['text' => date('H:i', strtotime($ticket->customer_time_in)), 'x' => 210, 'y' => 110],
                ['text' => $ticket->customer_time_out, 'x' => 241, 'y' => 110],
                
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            
            return $outputFile;
        }else{
            return false;
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

            $fpdi->SetFont('Helvetica', '', 10);
            foreach ($fields as $field) {
                $fpdi->SetXY($field['x'], $field['y']);
                // set font custom
                if(isset($field['font'])){
                    $fpdi->SetFont('Helvetica', '', $field['font']);
                }
                // set cell dimensions
                if (isset($field['width']) && isset($field['height'])) {
                    // Use MultiCell to prevent text from overflowing
                    $fpdi->MultiCell($field['width'], $field['height'], $field['text']);
                } else {
                    // Use Write for single-line text fields
                    $fpdi->Write(8, $field['text']);
                }
            }
        }

        $fpdi->Output($output_file, 'F');
        // sendMailAttachment('Admin Team', 'hamza@5dsolutions.ae', 'Superior Crane', 'Rigger Ticket Generated', 'Rigger Ticket Generated', $output_file); // send_to_name, send_to_email, email_from_name, subject, body, attachment

        return $output_file;
    }
}
