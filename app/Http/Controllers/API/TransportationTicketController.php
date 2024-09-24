<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobModel;
use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class TransportationTicketController extends Controller
{
    public function add_transportation_ticket(Request $request)
    {
        $request->merge([
            'time_in' => $request->input('time_in') != null ? date('H:i', strtotime($request->input('time_in'))) : null,
            'time_out' => $request->input('time_out') != null ? date('H:i', strtotime($request->input('time_out'))) : null,
            'shipper_time_in' => $request->input('shipper_time_in') != null ? date('H:i', strtotime($request->input('shipper_time_in'))) : null,
            'shipper_time_out' => $request->input('shipper_time_out') != null ? date('H:i', strtotime($request->input('shipper_time_out'))) : null,
            'pickup_driver_time_in' => $request->input('pickup_driver_time_in') != null ? date('H:i', strtotime($request->input('pickup_driver_time_in'))) : null,
            'pickup_driver_time_out' => $request->input('pickup_driver_time_out') != null ? date('H:i', strtotime($request->input('pickup_driver_time_out'))) : null,
            'customer_time_in' => $request->input('customer_time_in') != null ? date('H:i', strtotime($request->input('customer_time_in'))) : null,
            'customer_time_out' => $request->input('customer_time_out') != null ? date('H:i', strtotime($request->input('customer_time_out'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'pickup_address' => 'required|string',
                'delivery_address' => 'required|string',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'required|date_format:H:i',
                'notes' => 'nullable|string',
                'job_number' => 'nullable|string|max:50',
                'job_special_instructions' => 'nullable|string',
                'po_number' => 'nullable|string|max:50',
                'po_special_instructions' => 'nullable|string',
                'site_contact_name' => 'nullable|string|max:100',
                'site_name_special_instructions' => 'nullable|string',
                'site_contact_number' => 'nullable|string|max:17',
                'site_number_special_instructions' => 'nullable|string',
                'shipper_name' => 'nullable|string|max:100',
                'shipper_signature' => 'nullable|string',
                'shipper_signature_date' => 'nullable|date',
                'shipper_time_in' => 'nullable|date_format:H:i',
                'shipper_time_out' => 'nullable|date_format:H:i',
                'pickup_driver_name' => 'nullable|string|max:100',
                'pickup_driver_signature' => 'nullable|string',
                'pickup_driver_signature_date' => 'nullable|date',
                'pickup_driver_time_in' => 'nullable|date_format:H:i',
                'pickup_driver_time_out' => 'nullable|date_format:H:i',
                'customer_name' => 'nullable|string|max:100',
                'customer_email' => 'nullable|string|email|max:100',
                'customer_signature' => 'nullable|string',
                'customer_signature_date' => 'nullable|date',
                'customer_time_in' => 'nullable|date_format:H:i',
                'customer_time_out' => 'nullable|date_format:H:i',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                // 'images' => 'required',
                'images.*.file' => 'string',
                'images.*.title' => 'string|max:255',
                'images.*.type' => 'string|max:255',
                // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
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
            $record->shipper_signature = $request->shipper_signature;
            $record->shipper_signature_date = $request->shipper_signature_date;
            $record->shipper_time_in = $request->shipper_time_in;
            $record->shipper_time_out = $request->shipper_time_out;
            $record->pickup_driver_name = $request->pickup_driver_name;
            $record->pickup_driver_signature = $request->pickup_driver_signature;
            $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
            $record->pickup_driver_time_in = $request->pickup_driver_time_in;
            $record->pickup_driver_time_out = $request->pickup_driver_time_out;
            $record->customer_name = $request->customer_name;
            $record->customer_email = $request->customer_email;
            $record->customer_signature = $request->customer_signature;
            $record->customer_signature_date = $request->customer_signature_date;
            $record->customer_time_in = $request->customer_time_in;
            $record->customer_time_out = $request->customer_time_out;
            $record->status = $request->status;
            $record->created_by = $request->created_by;
            $record->save();

            if($request->status == '3'){
                JobModel::where('id', $record->job_id)->update(['status' => '3']);
            }

            $images = $request->images;
            if(is_countable($images) && count($images) > 0){
                
                foreach ($images as $index => $imageData) {
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

                    $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $record->id;
                    $TransportationTicketImages->path = '/public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->type = $type == 'image' ? 'png' : 'pdf';
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
        $request->merge([
            'time_in' => $request->input('time_in') != null ? date('H:i', strtotime($request->input('time_in'))) : null,
            'time_out' => $request->input('time_out') != null ? date('H:i', strtotime($request->input('time_out'))) : null,
            'shipper_time_in' => $request->input('shipper_time_in') != null ? date('H:i', strtotime($request->input('shipper_time_in'))) : null,
            'shipper_time_out' => $request->input('shipper_time_out') != null ? date('H:i', strtotime($request->input('shipper_time_out'))) : null,
            'pickup_driver_time_in' => $request->input('pickup_driver_time_in') != null ? date('H:i', strtotime($request->input('pickup_driver_time_in'))) : null,
            'pickup_driver_time_out' => $request->input('pickup_driver_time_out') != null ? date('H:i', strtotime($request->input('pickup_driver_time_out'))) : null,
            'customer_time_in' => $request->input('customer_time_in') != null ? date('H:i', strtotime($request->input('customer_time_in'))) : null,
            'customer_time_out' => $request->input('customer_time_out') != null ? date('H:i', strtotime($request->input('customer_time_out'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'ticket_id' => 'required',
                'user_id' => 'required',
                'job_id' => 'required',
                'pickup_address' => 'required|string',
                'delivery_address' => 'required|string',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'required|date_format:H:i',
                'notes' => 'nullable|string',
                'job_number' => 'nullable|string|max:50',
                'job_special_instructions' => 'nullable|string',
                'po_number' => 'nullable|string|max:50',
                'po_special_instructions' => 'nullable|string',
                'site_contact_name' => 'nullable|string|max:100',
                'site_name_special_instructions' => 'nullable|string',
                'site_contact_number' => 'nullable|string|max:17',
                'site_number_special_instructions' => 'nullable|string',
                'shipper_name' => 'nullable|string|max:100',
                'shipper_signature' => 'nullable|string',
                'shipper_signature_date' => 'nullable|date',
                'shipper_time_in' => 'nullable|date_format:H:i',
                'shipper_time_out' => 'nullable|date_format:H:i',
                'pickup_driver_name' => 'nullable|string|max:100',
                'pickup_driver_signature' => 'nullable|string',
                'pickup_driver_signature_date' => 'nullable|date',
                'pickup_driver_time_in' => 'nullable|date_format:H:i',
                'pickup_driver_time_out' => 'nullable|date_format:H:i',
                'customer_name' => 'nullable|string|max:100',
                'customer_email' => 'nullable|string|email|max:100',
                'customer_signature' => 'nullable|string',
                'customer_signature_date' => 'nullable|date',
                'customer_time_in' => 'nullable|date_format:H:i',
                'customer_time_out' => 'nullable|date_format:H:i',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                // 'images' => 'required',
                // 'images.*.file' => 'required|string',
                // 'images.*.title' => 'required|string|max:255',
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'ticket_id' => 'required',
                'user_id' => 'required',
                'job_id' => 'required',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
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
                $record->shipper_signature = $request->shipper_signature;
                $record->shipper_signature_date = $request->shipper_signature_date;
                $record->shipper_time_in = $request->shipper_time_in;
                $record->shipper_time_out = $request->shipper_time_out;
                $record->pickup_driver_name = $request->pickup_driver_name;
                $record->pickup_driver_signature = $request->pickup_driver_signature;
                $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
                $record->pickup_driver_time_in = $request->pickup_driver_time_in;
                $record->pickup_driver_time_out = $request->pickup_driver_time_out;
                $record->customer_name = $request->customer_name;
                $record->customer_email = $request->customer_email;
                $record->customer_signature = $request->customer_signature;
                $record->customer_signature_date = $request->customer_signature_date;
                $record->customer_time_in = $request->customer_time_in;
                $record->customer_time_out = $request->customer_time_out;
                $record->status = $request->status;
                $record->created_by = $request->created_by;
                $record->save();

                if($request->status == '3'){
                    JobModel::where('id', $record->job_id)->update(['status' => '3']);
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

    public function addTicketImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            'images.*.type' => 'required|string|max:255',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $images = $request->images;
            if(is_countable($images) && count($images) > 0){
                
                foreach ($images as $index => $imageData) {
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
                    
                    $filePath = public_path('uploads/transportation_tickets_images/' . $request->ticket_id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $request->ticket_id;
                    $TransportationTicketImages->path = '/public/uploads/transportation_tickets_images/' . $request->ticket_id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->type = $type == 'image' ? 'png' : 'pdf';
                    $TransportationTicketImages->save();
                }
            }

            $ticket_images = TransportationTicketImages::where('ticket_id', $request->ticket_id)->get();

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

            TransportationTicketImages::where('ticket_id', $request->ticket_id)->where('id', $request->image_id)->delete();

            $ticket_images = TransportationTicketImages::where('ticket_id', $request->ticket_id)->get();

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

            $transportation_ticket_list = TransportationTicketModel::where('user_id', $request->user_id)->with(['ticketImages'])->get();
            
            if($transportation_ticket_list) {
                return response()->json([
                    'success' => true,
                    'total' => count($transportation_ticket_list),
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

        $ticketDetail = TransportationTicketModel::where('id', $ticket_id)->first();

        if($ticketDetail->status == '3'){       // if status is (3) completed  then send email
            
            $attachment_pdf = $this->makeTicketPDF($ticket_id);

            if($attachment_pdf){
            
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
                    }else{
                        $status_txt = '';
                    }
                    
                    $mailData = [];
                    
                    $mailData['user'] = $managerDetail->name;
                    $mailData['transporter_name'] = $transporterDetail->name;
                    $mailData['job_number'] = 'J-'.$ticketDetail->job_id;
                    $mailData['ticket_number'] = 'T-'.$ticketDetail->id;
                    $mailData['pickup_address'] = $ticketDetail->pickup_address;
                    $mailData['delivery_address'] = $ticketDetail->delivery_address;

                    $mailData['po_number'] = $ticketDetail->po_number;
                    $mailData['ticket_date'] = $ticketDetail->created_at != null ? date('d-M-Y', strtotime($ticketDetail->created_at)) : '';
                    $mailData['time_in'] = $ticketDetail->time_in != null ? date('H:i A', strtotime($ticketDetail->time_in)) : '';
                    $mailData['time_out'] = $ticketDetail->time_out != null ? date('H:i A', strtotime($ticketDetail->time_out)) : '';
                    $mailData['status'] = $status_txt;
    
                    $mailData['text1'] = "New Transporter Ticket has been created. Ticket details are as under.";
                    $mailData['text2'] = "For more details please contact the Manager/Admin.";
    
                    $body = view('emails.transporter_ticket_template', $mailData);
                    $userEmailsSend = $managerDetail->email;//'hamza@5dsolutions.ae';//
                    sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);

                    if(isset($ticketDetail->customer_email) && $ticketDetail->customer_email != null){
                        $mailData['user'] = $ticketDetail->customer_name;
                        $body = view('emails.transporter_ticket_template', $mailData);
                        sendMailAttachment($ticketDetail->customer_name, $ticketDetail->customer_email, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);
                    }
                    
                    // push notification entry
                    $Notifications = new Notifications();
                    $Notifications->module_code = 'TRANSPORTER TICKET SUBMITTED';
                    $Notifications->from_user_id = $transporterDetail->id;
                    $Notifications->to_user_id = '1';   // for super admin
                    $Notifications->subject = 'Transporter Ticket Submitted';
                    $Notifications->message = 'Transporter Ticket T-'.$ticketDetail->id.' on '.$ticketDetail->created_at != null ? date('d-M-Y', strtotime($ticketDetail->created_at)) : ''.' has been submitted by '.$transporterDetail->name.'.';
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
                            $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
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
                ['base64_image' => $ticket->shipper_signature, 'x' => 122, 'y' => 98, 'width' => 20, 'height' => 5],
                ['text' => $ticket->shipper_signature_date != null ? date('d-M-Y', strtotime($ticket->shipper_signature_date)) : '', 'x' => 164, 'y' => 96.5],
                ['text' => $ticket->shipper_time_in != null ? date('H:i', strtotime($ticket->shipper_time_in)) : '', 'x' => 210, 'y' => 96.5],
                ['text' => $ticket->shipper_time_out, 'x' => 241, 'y' => 96.5],

                ['text' => $ticket->pickup_driver_name, 'x' => 58, 'y' => 103],
                ['base64_image' => $ticket->pickup_driver_signature, 'x' => 122, 'y' => 104.5, 'width' => 20, 'height' => 5],
                ['text' => $ticket->pickup_driver_signature_date != null ? date('d-M-Y', strtotime($ticket->pickup_driver_signature_date)) : '', 'x' => 164, 'y' => 103],
                ['text' => $ticket->pickup_driver_time_in != null ? date('H:i', strtotime($ticket->pickup_driver_time_in)) : '', 'x' => 210, 'y' => 103],
                ['text' => $ticket->pickup_driver_time_out, 'x' => 241, 'y' => 103],

                ['text' => $ticket->customer_name, 'x' => 58, 'y' => 110],
                ['base64_image' => $ticket->customer_signature, 'x' => 122, 'y' => 111, 'width' => 20, 'height' => 5],
                ['text' => $ticket->customer_signature_date != null ? date('d-M-Y', strtotime($ticket->customer_signature_date)) : '', 'x' => 164, 'y' => 110],
                ['text' => $ticket->customer_time_in != null ? date('H:i', strtotime($ticket->customer_time_in)) : '', 'x' => 210, 'y' => 110],
                ['text' => $ticket->customer_time_out, 'x' => 241, 'y' => 110],
                
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            
            return $outputFile;//'/public'.
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
                
                if(isset($field['base64_image'])){
                    if($field['base64_image'] != '' && $field['base64_image'] != null){
                        // Decode the base64 image and save it to a temporary file
                        $imageData = base64_decode($field['base64_image']);
                        $tempFilePath = tempnam(sys_get_temp_dir(), 'sig_') . '.png';
                        file_put_contents($tempFilePath, $imageData);

                        // Add the image to the PDF
                        $fpdi->Image($tempFilePath, $field['x'], $field['y'], $field['width'], $field['height']);

                        // Remove the temporary file
                        unlink($tempFilePath);
                    }else{
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
                    } else if(isset($field['text'])){
                        $fpdi->Write(8, isset($field['text']) ? $field['text'] : '');
                    }else{
                        $fpdi->Write(8, '');
                    }
                }
            }
        }

        $fpdi->Output($output_file, 'F');
        
        return $output_file;
    }
}
