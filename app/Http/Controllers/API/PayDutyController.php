<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayDutyModel;
use App\Models\PayDutytImages;
use App\Models\User;
use App\Models\JobModel;
use App\Models\RiggerTicket;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class PayDutyController extends Controller
{
    public function add_pay_duty(Request $request)
    {
        $request->merge([
            'start_time' => $request->input('start_time') != null ? date('H:i', strtotime($request->input('start_time'))) : null,
            'finish_time' => $request->input('finish_time') != null ? date('H:i', strtotime($request->input('finish_time'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'rigger_ticket_id' => 'required',
                'date' => 'required|date',
                'location' => 'required|string',
                'start_time' => 'required|date_format:H:i',
                'finish_time' => 'required|date_format:H:i',
                'total_hours' => 'required|string|max:100',
                'officer' => 'nullable|max:100',
                'officer_name' => 'required|string|max:100',
                'division' => 'nullable|max:200',
                'email' => 'required|string|email|max:100',
                'signature' => 'required|string',
                // 'images' => 'required',
                'images.*.file' => 'string',
                'images.*.title' => 'string|max:255',
                'images.*.type' => 'string|max:255',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'rigger_ticket_id' => 'required',
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
            $form = new PayDutyModel;
            $form->user_id = $request->user_id;
            $form->rigger_ticket_id = $request->rigger_ticket_id;
            $form->date = $request->date;
            $form->location = $request->location;
            $form->start_time = $request->start_time;
            $form->finish_time = $request->finish_time;
            $form->total_hours = $request->total_hours;
            $form->officer = $request->officer;
            $form->officer_name = $request->officer_name;
            $form->division = $request->division;
            $form->email = $request->email;
            $form->signature = $request->signature;
            $form->status = $request->status;
            $form->created_by = $request->created_by;
            $form->save();

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

                    $filePath = public_path('uploads/pay_duty_images/' . $form->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $PayDutytImages = new PayDutytImages();
                    $PayDutytImages->pay_duty_id = $form->id;
                    $PayDutytImages->path = '/public/uploads/pay_duty_images/' . $form->id . '/' . $imageName;
                    $PayDutytImages->file_name = $title;
                    $PayDutytImages->type = $type == 'image' ? 'png' : 'pdf';
                    $PayDutytImages->save();
                }
            }

            $this->sendEmailPayDutyForm($form->id);

            return response()->json([
                'success' => true,
                'message' => 'Pay duty form added successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding pay duty form: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function update_pay_duty(Request $request)
    {
        $request->merge([
            'start_time' => $request->input('start_time') != null ? date('H:i', strtotime($request->input('start_time'))) : null,
            'finish_time' => $request->input('finish_time') != null ? date('H:i', strtotime($request->input('finish_time'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'pay_duty_id' => 'required',
                'user_id' => 'required',
                'rigger_ticket_id' => 'required',
                'date' => 'required|date',
                'location' => 'required|string',
                'start_time' => 'required|date_format:H:i',
                'finish_time' => 'required|date_format:H:i',
                'total_hours' => 'required|string|max:100',
                'officer' => 'nullable|max:100',
                'officer_name' => 'required|string|max:100',
                'division' => 'nullable|max:200',
                'email' => 'required|string|email|max:100',
                'signature' => 'required|string',
                // 'images' => 'required',
                // 'images.*.file' => 'required|string',
                // 'images.*.title' => 'required|string|max:255',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'pay_duty_id' => 'required',
                'user_id' => 'required',
                'rigger_ticket_id' => 'required',
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
            $form = PayDutyModel::where("id", $request->pay_duty_id)->first();
            if($form){
                // $form->rigger_ticket_id = $request->rigger_ticket_id;
                $form->date = $request->date;
                $form->location = $request->location;
                $form->start_time = $request->start_time;
                $form->finish_time = $request->finish_time;
                $form->total_hours = $request->total_hours;
                $form->officer = $request->officer;
                $form->officer_name = $request->officer_name;
                $form->division = $request->division;
                $form->email = $request->email;
                $form->signature = $request->signature;
                $form->status = $request->status;
                $form->created_by = $request->created_by;
                $form->save();

               
                $this->sendEmailPayDutyForm($form->id);
            }
            return response()->json([
                'success' => true,
                'message' => 'Pay duty form updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding pay duty form: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function addPayDutyImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_duty_id' => 'required|numeric',
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

                    $filePath = public_path('uploads/pay_duty_images/' . $request->pay_duty_id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $PayDutytImages = new PayDutytImages();
                    $PayDutytImages->pay_duty_id = $request->pay_duty_id;
                    $PayDutytImages->path = '/public/uploads/pay_duty_images/' . $request->pay_duty_id . '/' . $imageName;
                    $PayDutytImages->file_name = $title;
                    $PayDutytImages->type = $type == 'image' ? 'png' : 'pdf';
                    $PayDutytImages->save();
                }
            }

            $duty_images = PayDutytImages::where('pay_duty_id', $request->pay_duty_id)->get();

            return response()->json([
                'success' => true,
                'duty_images' => $duty_images,
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

    public function deletePayDutyImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_duty_id' => 'required|numeric',
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

            PayDutytImages::where('pay_duty_id', $request->pay_duty_id)->where('id', $request->image_id)->delete();

            $duty_images = PayDutytImages::where('pay_duty_id', $request->pay_duty_id)->get();

            return response()->json([
                'success' => true,
                'duty_images' => $duty_images,
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

    public function getPayDutyList(Request $request)
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

        // try {

            // $pay_duties = PayDutyModel::where('user_id', $request->user_id)->with(['dutyImages'])->get();
            $pay_duties = PayDutyModel::where('user_id', $request->user_id)
                                        ->whereHas('riggerTicket', function ($query) use ($request) {
                                            $query->where('status', '3');
                                        })->with(['dutyImages','riggerTicket'])->get();
            
            if($pay_duties) {
                return response()->json([
                    'success' => true,
                    'duty_list' => $pay_duties,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Data Found',
                ], 401);
            }

        // } catch (\Exception $e) {
        //     // Log the error for debugging purposes
        //     Log::error('Error loading job: ' . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => "Oops! Network Error",
        //     ], 500);
        // }
    }

    public function getPayDutyDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_duty_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // try {

            $pay_duty_detail = PayDutyModel::where('id', $request->pay_duty_id)->with(['dutyImages','riggerTicket'])->first();
            if($pay_duty_detail) {
                
                $ticket = RiggerTicket::where('id', $pay_duty_detail->rigger_ticket_id)->first();
                
                $jobAddress = JobModel::where('id', $ticket->job_id)->value('address');
                
                if($jobAddress){
                    $pay_duty_detail->ticket_name = 'RTKT-' . $ticket->id . ' | ' . $ticket->customer_name . ' | ' . substr($jobAddress, 0, 12).'...';
                }else{
                    $pay_duty_detail->ticket_name = 'RTKT-'.$ticket->id .' | '.$ticket->customer_name;
                }
                
                return response()->json([
                    'success' => true,
                    'pay_duty_detail' => $pay_duty_detail,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Data Found',
                ], 401);
            }
        // } catch (\Exception $e) {
        //     // Log the error for debugging purposes
        //     Log::error('Error loading job: ' . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => "Oops! Network Error",
        //     ], 500);
        // }
    }

    public function sendEmailPayDutyForm($form_id){

        $formDetail = PayDutyModel::where('id', $form_id)->first();

        if($formDetail->status == '3'){       // if status is (3) completed  then send email
            
            $attachment_pdf = $this->makeRiggerPDF($form_id);
            
            if($attachment_pdf){
                
                $riggerDetail = User::where('id', $formDetail->user_id)->first(); 
                $ticketDetail = RiggerTicket::where('id', $formDetail->rigger_ticket_id)->first();  // linked rigger ticket details
                $jobDetail = JobModel::where('id', $ticketDetail->job_id)->first(); // lnked job details
                $managerDetail = User::where('id', $jobDetail->created_by)->first(); // manager/createby details

                if($formDetail->status == '1'){
                    $status_txt = 'Draft';
                }else if($formDetail->status == '2'){
                    $status_txt = 'Issued';
                }else if($formDetail->status == '3'){
                    $status_txt = 'Completed';
                }else{
                    $status_txt = '';
                }
                
                $mailData = [];
                
                $mailData['user'] = $managerDetail->name;
                $mailData['rigger_name'] = $riggerDetail->name;
                $mailData['rigger_number'] = 'RTKT-'.$formDetail->rigger_ticket_id;
                $mailData['form_number'] = 'PDTY-'.$formDetail->id;
                
                $mailData['form_date'] = $formDetail->date != null ? date('d-M-Y', strtotime($formDetail->date)) : '';
                $mailData['location'] = $formDetail->location;
                $mailData['start_time'] = $formDetail->start_time != null ? date('H:i A', strtotime($formDetail->start_time)) : '';
                $mailData['finish_time'] = $formDetail->finish_time != null ? date('H:i A', strtotime($formDetail->finish_time)) : '';
                $mailData['status'] = $status_txt;

                $mailData['text1'] = "New Pay Duty Form has been created. Pay Duty details are as under.";
                $mailData['text2'] = "For more details please contact the Manager/Admin.";

                $body = view('emails.pay_duty_form_template', $mailData);
                $userEmailsSend = $managerDetail->email;//'hamza@5dsolutions.ae';//
                sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Pay Duty Form Creation', $body, $attachment_pdf);

                if($ticketDetail->email !=  null && $ticketDetail->email != ''){
                    $mailData['user'] = $ticketDetail->customer_name;
                    $body = view('emails.pay_duty_form_template', $mailData);
                    sendMailAttachment($ticketDetail->customer_name, $ticketDetail->email, 'Superior Crane', 'Pay Duty Form Creation', $body, $attachment_pdf);
                }
                
                if($formDetail->email !=  null && $formDetail->email != ''){
                    $mailData['user'] = $formDetail->officer_name;
                    $body = view('emails.pay_duty_form_template', $mailData);
                    sendMailAttachment($formDetail->officer_name, $formDetail->email, 'Superior Crane', 'Pay Duty Form Creation', $body, $attachment_pdf);
                }

                // push notification entry
                $Notifications = new Notifications();
                $Notifications->module_code = 'PAY DUTY SUBMIT';
                $Notifications->from_user_id = $riggerDetail->id;
                $Notifications->to_user_id = '1';   // for super admin
                $Notifications->subject = 'Pay Duty From Submitted';
                $Notifications->message = 'Pay Duty From PDTY-'.$formDetail->id.' on '.$formDetail->date != null ? date('d-M-Y', strtotime($formDetail->date)) : ''.' has been submitted by '.$riggerDetail->name.'.';
                $Notifications->message_html = $body;
                $Notifications->read_flag = '0';
                $Notifications->created_by = $riggerDetail->id;
                $Notifications->created_at = date('Y-m-d H:i:s');
                $Notifications->save();

                $allAdmins = User::whereIn('role_id', ['0','1'])->where('status', '1')->get();

                if($allAdmins){
                    foreach($allAdmins as $value){
                        $mailData['user'] = $value->name;
                        $body = view('emails.pay_duty_form_template', $mailData);
                        $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                        sendMailAttachment($value->name, $userEmailsSend, 'Superior Crane', 'Pay Duty Form Creation', $body, $attachment_pdf);
                    }
                }
            }
        }
    }
    public function makeRiggerPDF($form_id='')
    {

        $id = $form_id;
        $filepath = public_path('assets/pdf/pdf_samples/pay_duty.pdf');
        $output_file_path = public_path('assets/pdf/pay_duty_pdfs/form_' .$id. '.pdf'); 
        $form = PayDutyModel::find($id);
        if($form){
            $fields = [
                ['text' => 'RTKT-'.$form->rigger_ticket_id, 'x' => 68, 'y' => 31],
                ['text' => 'PDTY-'.$form->id, 'x' => 167, 'y' => 31],
                ['text' => $form->date != null ? date('d-M-Y', strtotime($form->date)) : '', 'x' => 86, 'y' => 87.5],
                ['text' => $form->location, 'x' => 86, 'y' => 105],
                ['text' => $form->start_time != null ? date('h:i', strtotime($form->start_time)) : '', 'x' => 86, 'y' => 123],
                ['text' => $form->finish_time != null ? date('h:i', strtotime($form->finish_time)) : '', 'x' => 86, 'y' => 141],

                ['text' => $form->total_hours != null ? date('h:i', strtotime($form->total_hours)) : '', 'x' => 86, 'y' => 159],
                ['text' => $form->officer, 'x' => 86, 'y' => 177],
                ['text' => $form->officer_name, 'x' => 110, 'y' => 194],
                ['text' => $form->division, 'x' => 86, 'y' => 212],
                // ['text' => $form->signature, 'x' => 88, 'y' => 230],
                ['base64_image' => $form->signature, 'x' => 100, 'y' => 225, 'width' => 30, 'height' => 10],

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
}
