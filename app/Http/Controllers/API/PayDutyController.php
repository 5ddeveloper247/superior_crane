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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'rigger_ticket_id' => 'required',
            'date' => 'required|date',
            'location' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i',
            'total_hours' => 'required|string|max:100',
            'officer' => 'required|string|max:100',
            'officer_name' => 'required|string|max:100',
            'division' => 'required|string|max:200',
            'email' => 'required|string|email|max:100',
            // 'signature' => 'required|string',
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
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
            // $form->signature = $request->signature;
            $form->status = $request->status;
            $form->created_by = $request->created_by;
            $form->save();

            if ($request->hasFile('signature')) {

                $path = '/uploads/pay_duty_images/' . $form->id . '/signature';
                $uploadedFile = $request->file('signature');
                $savedFile = saveSingleImage($uploadedFile, $path);
                $full_path = url('/public/') . $savedFile;
                $form->signature = $full_path;
                $form->save();
            }

            // $req_file = 'images';
            // $path = '/uploads/pay_duty_images/' . $form->id .'/images';

            // if ($request->hasFile($req_file)) {

            //     if (!File::isDirectory(public_path($path))) {
            //         File::makeDirectory(public_path($path), 0777, true);
            //     }
                
            //     $uploadedFiles = $request->file($req_file);

            //     foreach ($uploadedFiles as $file) {
            //         $file_extension = $file->getClientOriginalExtension();
            //         $date_append = Str::random(32);
            //         $file->move(public_path($path), $date_append . '.' . $file_extension);
    
            //         $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

            //         $PayDutytImages = new PayDutytImages();
            //         $PayDutytImages->pay_duty_id = $form->id;
            //         $PayDutytImages->file_name = $file->getClientOriginalName();
            //         $PayDutytImages->path = $savedFilePaths;
            //         $PayDutytImages->save();
            //     }
            // }

            $images = $request->images;
            if(count($images) > 0){
                
                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = Str::random(32).'.'.'png';
                    $filePath = public_path('uploads/pay_duty_images/' . $form->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $PayDutytImages = new PayDutytImages();
                    $PayDutytImages->pay_duty_id = $form->id;
                    $PayDutytImages->path = 'public/uploads/pay_duty_images/' . $form->id . '/' . $imageName;
                    $PayDutytImages->file_name = $title;
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
        $validator = Validator::make($request->all(), [
            'pay_duty_id' => 'required',
            'user_id' => 'required',
            'rigger_ticket_id' => 'required',
            'date' => 'required|date',
            'location' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i',
            'total_hours' => 'required|string|max:100',
            'officer' => 'required|string|max:100',
            'officer_name' => 'required|string|max:100',
            'division' => 'required|string|max:200',
            'email' => 'required|string|email|max:100',
            // 'signature' => 'required|string',
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
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
                // $form->signature = $request->signature;
                $form->status = $request->status;
                $form->created_by = $request->created_by;
                $form->save();

                if ($request->hasFile('signature')) {

                    $del_path = str_replace(url('/public/'), '', $form->signature);
                    deleteImage($del_path);

                    $path = '/uploads/pay_duty_images/' . $form->id . '/signature';
                    $uploadedFile = $request->file('signature');
                    $savedFile = saveSingleImage($uploadedFile, $path);
                    $full_path = url('/public/') . $savedFile;
                    $form->signature = $full_path;
                    $form->save();
                }

            //     $req_file = 'images';
            //     $path = '/uploads/pay_duty_images/' . $form->id .'/images';

            //     if ($request->hasFile($req_file)) {

                    // $previous_images = PayDutytImages::where('pay_duty_id', $form->id)->get();
                    // if(count($previous_images) > 0){
                    //     foreach($previous_images as $img){
                    //         $del_path = str_replace(url('/public/'), '', $img->path);
                    //         deleteImage($del_path);
                    //         PayDutytImages::where('id', $img->id)->delete();
                    //     }
                    // }

                    // if (!File::isDirectory(public_path($path))) {
                    //     File::makeDirectory(public_path($path), 0777, true);
                    // }
                    
            //         $uploadedFiles = $request->file($req_file);

            //         foreach ($uploadedFiles as $file) {
            //             $file_extension = $file->getClientOriginalExtension();
            //             $date_append = Str::random(32);
            //             $file->move(public_path($path), $date_append . '.' . $file_extension);
        
            //             $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

            //             $PayDutytImages = new PayDutytImages();
            //             $PayDutytImages->ticket_id = $form->id;
            //             $PayDutytImages->file_name = $file->getClientOriginalName();
            //             $PayDutytImages->path = $savedFilePaths;
            //             $PayDutytImages->save();
            //         }
            //     }
            
            $images = $request->images;
            if(count($images) > 0){
                
                $previous_images = PayDutytImages::where('pay_duty_id', $form->id)->get();
                if(count($previous_images) > 0){
                    foreach($previous_images as $img){
                        $del_path = str_replace(url('/public/'), '', $img->path);
                        deleteImage($del_path);
                        PayDutytImages::where('id', $img->id)->delete();
                    }
                }

                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = Str::random(32).'.'.'png';
                    $filePath = public_path('uploads/pay_duty_images/' . $form->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $PayDutytImages = new PayDutytImages();
                    $PayDutytImages->pay_duty_id = $form->id;
                    $PayDutytImages->path = 'public/uploads/pay_duty_images/' . $form->id . '/' . $imageName;
                    $PayDutytImages->file_name = $title;
                    $PayDutytImages->save();
                }
            }
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

        try {

            $pay_duties = PayDutyModel::where('user_id', $request->user_id)->with(['dutyImages'])->get();
            
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

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
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

        try {

            $pay_duty_detail = PayDutyModel::where('id', $request->pay_duty_id)->with(['dutyImages'])->first();
            if($pay_duty_detail) {
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
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function sendEmailPayDutyForm($form_id){

        $attachment_pdf = $this->makeRiggerPDF($form_id);

        if($attachment_pdf){
            
            $formDetail = PayDutyModel::where('id', $form_id)->first();
            
            if($formDetail->status == '3'){       // if status is (3) completed  then send email
                
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
                }
                
                $mailData = [];
                
                $mailData['user'] = $managerDetail->name;
                $mailData['rigger_name'] = $riggerDetail->name;
                $mailData['rigger_number'] = 'R-'.$formDetail->rigger_ticket_id;
                $mailData['form_number'] = 'P-'.$formDetail->id;
                
                $mailData['form_date'] = date('d-M-Y', strtotime($formDetail->date));
                $mailData['location'] = $formDetail->location;
                $mailData['start_time'] = date('H:i A', strtotime($formDetail->start_time));
                $mailData['finish_time'] = date('H:i A', strtotime($formDetail->finish_time));
                $mailData['status'] = $status_txt;

                $mailData['text1'] = "New Pay Duty Form has been created. Pay Duty details are as under.";
                $mailData['text2'] = "For more details please contact the Manager/Admin.";

                $body = view('emails.pay_duty_form_template', $mailData);
                $userEmailsSend = 'hamza@5dsolutions.ae';//$managerDetail->email;
                sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Pay Duty Form Creation', $body, $attachment_pdf);

                // push notification entry
            $Notifications = new Notifications();
            $Notifications->module_code = 'PAY DUTY SUBMIT';
            $Notifications->from_user_id = $riggerDetail->id;
            $Notifications->to_user_id = '1';   // for super admin
            $Notifications->subject = 'Pay Duty From Submitted';
            $Notifications->message = 'Pay Duty From P-'.$formDetail->id.' on '.date('d-M-Y', strtotime($formDetail->date)).' has been submitted by '.$riggerDetail->name.'.';
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
                        $userEmailsSend = 'hamza@5dsolutions.ae';//$value->email;
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
                ['text' => 'R-'.$form->rigger_ticket_id, 'x' => 68, 'y' => 31],
                ['text' => 'P-'.$form->id, 'x' => 167, 'y' => 31],
                ['text' => date('d-M-Y', strtotime($form->date)), 'x' => 86, 'y' => 87.5],
                ['text' => $form->location, 'x' => 86, 'y' => 105],
                ['text' => date('h:i', strtotime($form->start_time)), 'x' => 86, 'y' => 123],
                ['text' => date('h:i', strtotime($form->finish_time)), 'x' => 86, 'y' => 141],

                ['text' => date('h:i', strtotime($form->total_hours)), 'x' => 86, 'y' => 159],
                ['text' => $form->officer, 'x' => 86, 'y' => 177],
                ['text' => $form->officer_name, 'x' => 110, 'y' => 194],
                ['text' => $form->division, 'x' => 86, 'y' => 212],
                ['text' => $form->signature, 'x' => 88, 'y' => 230],
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
