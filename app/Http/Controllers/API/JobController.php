<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use App\Models\JobModel;
use App\Models\JobImages;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

use App\Models\RiggerTicket;
use App\Models\TransportationTicketModel;
use App\Models\PayDutyModel;


class JobController extends Controller
{
    public function add_job(Request $request)
    {
        $request->merge([
            'start_time' => $request->input('start_time') != '' ? date('H:i', strtotime($request->input('start_time'))) : '',
            // 'end_time' => $request->input('end_time') != '' ? date('H:i', strtotime($request->input('end_time'))) : '',
            'date' => $request->input('date') != '' ? date('Y-m-d', strtotime($request->input('date'))) : '',
        ]);

        $validator = Validator::make($request->all(), [
            'job_type' => 'required',
            // 'job_time' => 'required|date_format:H:i',
            'client_name' => 'required|string|max:50',
            'equipment_to_be_used' => 'max:255',
            'rigger_assigned' => 'required_unless:job_type,3|array',
            'user_assigned' => 'max:50',
            'date' => 'required|date_format:Y-m-d',
            'address' => 'required|string|max:200',
            'start_time' => 'required|date_format:H:i',
            // 'end_time' => 'required|date_format:H:i|after:start_time',
            'supplier_name' => 'max:50',
            'notes' => 'nullable|string',
            // 'scci' => 'boolean',
            // 'job_images' => 'required',
            'job_images.*.file' => 'string',
            'job_images.*.title' => 'string|max:255',
            'job_images.*.type' => 'string|max:255',
            // 'status' => 'required',
            'created_by' => 'required|integer'
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $job = new JobModel;
            $job->job_type = $request->job_type;
            // $job->job_time = $request->job_time;
            $job->equipment_to_be_used = $request->equipment_to_be_used;
            $job->client_name = $request->client_name;
            $job->rigger_assigned = json_encode($request->rigger_assigned);
            $job->user_assigned = $request->user_assigned;
            $job->date = date("Y-m-d", strtotime($request->date));
            $job->address = $request->address;
            $job->start_time = $request->start_time;
            // $job->end_time = isset($request->end_time) ? $request->end_time : '';
            $job->supplier_name = $request->supplier_name;
            $job->notes = $request->notes;
            // $job->scci = $request->scci ?? false;
            $job->status = $request->status != '' ? $request->status : '1';     //2=>on-hold, 1=>goodtogo , 3=>complete
            $job->created_by = $request->created_by;
            $job->save();
    
            $job_images = $request->job_images;
            if(is_countable($job_images) && count($job_images) > 0){
                foreach ($job_images as $index => $imageData) {
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
                    
                    $filePath = public_path('uploads/job_images/' . $job->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
                    
                    // Save image path and title to database
                    $jobImage = new JobImages();
                    $jobImage->job_id = $job->id;
                    $jobImage->path = '/public/uploads/job_images/' . $job->id . '/' . $imageName;
                    $jobImage->file_name = $title;
                    $jobImage->type = $type == 'image' ? 'png' : 'pdf';
                    $jobImage->save();
                }
            }
            
            $jobDetail = JobModel::where('id', $job->id)->first();
            $riggerAssignedIds = json_decode($jobDetail->rigger_assigned);
            $assignedUsers = User::whereIn('id', $riggerAssignedIds)->where('status', '1')->get();// assigned user details
            
            $createdBy = User::where('id', $jobDetail->created_by)->first();
            
            if($jobDetail->job_type == '1'){
                $job_type = 'Logistic Job(SCCI)';  
            }else if($jobDetail->job_type == '2'){
                $job_type = 'Crane Job';  
            }else{
                $job_type = 'Other Job';  
            }

            if($jobDetail->status == '0'){
                $status_txt = 'Problem';
            }else if($jobDetail->status == '1'){
                $status_txt = 'Good To Go';
            }else if($jobDetail->status == '2'){
                $status_txt = 'On-Hold';
            }else{
                $status_txt = '';
            }
            
            $mailData = [];
            
            
            $mailData['job_number'] = 'J-'.$jobDetail->id;
            $mailData['job_type'] = $job_type;
            $mailData['client_name'] = $jobDetail->client_name;
            $mailData['job_address'] = $jobDetail->address;
            $mailData['job_date'] = date('d M,Y', strtotime($jobDetail->date));
            $mailData['start_time'] = date('H:i A', strtotime($jobDetail->start_time));
            $mailData['end_time'] = date('H:i A', strtotime($jobDetail->end_time));
            $mailData['status'] = $status_txt;
            $mailData['text1'] = "New job has been assigned by " . $createdBy->name . ". Job details are as under.";
            $mailData['text2'] = "For more details please contact the Manager/Admin.";
            $body = view('emails.job_template', $mailData);

            if($jobDetail->job_type != 3){
                foreach($assignedUsers as $user){
                    $mailData['user'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $mailData['username'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $mailData['assigned_to'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $body = view('emails.job_template', $mailData);
                    $userEmailsSend = $user->email;//'hamza@5dsolutions.ae';//
                    sendMail(isset($user->name) ? $user->name : $jobDetail->user_assigned, $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
                }
            }
            
            // push notification entry
            $Notifications = new Notifications();
            $Notifications->module_code = 'JOB CREATION';
            $Notifications->from_user_id = $createdBy->id;
            $Notifications->to_user_id = '1';
            $Notifications->subject = 'Assigned a new '. $job_type;
            if($jobDetail->job_type != 3){
                $Notifications->message = 'Job J-'.$jobDetail->id.' on '.date('d-M-Y', strtotime($jobDetail->date)).' at '.date('H:i A', strtotime($jobDetail->job_time)).' has been assigned to '.  isset($user->name) ? $user->name : $jobDetail->user_assigned .'.';
            }else{
                $Notifications->message = 'Job J-'.$jobDetail->id.' on '.date('d-M-Y', strtotime($jobDetail->date)).' at '.date('H:i A', strtotime($jobDetail->job_time)).' has been assigned to '.$jobDetail->user_assigned.'.';
            }
            $Notifications->message_html = $body;
            $Notifications->read_flag = '0';
            $Notifications->created_by = $createdBy->id;
            $Notifications->created_at = date('Y-m-d H:i:s');
            $Notifications->save();
            
            $allAdmins = User::whereIn('role_id', ['0','1'])->where('status', '1')->get();

            if($allAdmins){
                foreach($allAdmins as $value){
                    $mailData['user'] = 'Admin';
                    $body = view('emails.job_template', $mailData);
                    $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                    sendMail('Admin', $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Job added successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function updatejob(Request $request)
    {
        $request->merge([
            'start_time' => $request->input('start_time') != '' ? date('H:i', strtotime($request->input('start_time'))) : '',
            // 'end_time' => $request->input('end_time') != '' ? date('H:i', strtotime($request->input('end_time'))) : '',
            'date' => $request->input('date') != '' ? date('Y-m-d', strtotime($request->input('date'))) : '',
        ]);
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'job_type' => 'required|string|max:50',
            // 'job_time' => 'required|date_format:H:i',
            'client_name' => 'required|string|max:50',
            'equipment_to_be_used' => 'max:255',
            'client_name' => 'required|string|max:50',
            'rigger_assigned' => 'required_unless:job_type,3|array',
            'user_assigned' => 'max:50',
            'date' => 'required|date_format:Y-m-d',
            'address' => 'required|string|max:200',
            'start_time' => 'required|date_format:H:i',
            // 'end_time' => 'required|date_format:H:i|after:start_time',
            'supplier_name' => 'max:50',
            'notes' => 'nullable|string',
            // 'scci' => 'boolean',
            // 'job_images' => 'required',
            // 'job_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required',
            'created_by' => 'required|integer'
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $job = JobModel::where('id',$request->job_id)->first();
            if($job){
                $job->job_type = $request->job_type;
                // $job->job_time = $request->job_time;
                $job->equipment_to_be_used = $request->equipment_to_be_used;
                $job->client_name = $request->client_name;
                $job->rigger_assigned = json_encode($request->rigger_assigned);
                $job->user_assigned = $request->user_assigned;
                $job->date = date("Y-m-d", strtotime($request->date));
                $job->address = $request->address;
                $job->start_time = $request->start_time;
                // $job->end_time = isset($request->end_time) ? $request->end_time : '';
                $job->supplier_name = $request->supplier_name;
                $job->notes = $request->notes;
                // $job->scci = $request->scci ?? false;
                $job->status = $request->status;
                $job->updated_by = $request->created_by;
                $job->save();
               
                return response()->json([
                    'success' => true,
                    'message' => 'Job updated successfully'
                ], 200);
            
            }else{

                return response()->json([
                    'success' => false,
                    'message' => 'Job Not Found'
                ], 401);
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error updating the job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }  
    }

    public function addJobImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric',
            'job_images' => 'required',
            'job_images.*.file' => 'required|string',
            'job_images.*.title' => 'required|string|max:255',
            'job_images.*.type' => 'required|string|max:255',

        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $job_images = $request->job_images;
            if(is_countable($job_images) && count($job_images) > 0){
                foreach ($job_images as $index => $imageData) {
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
                    
                    $filePath = public_path('uploads/job_images/' . $request->job_id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
                    
                    // Save image path and title to database
                    $jobImage = new JobImages();
                    $jobImage->job_id = $request->job_id;
                    $jobImage->path = '/public/uploads/job_images/' . $request->job_id . '/' . $imageName;
                    $jobImage->file_name = $title;
                    $jobImage->type = $type == 'image' ? 'png' : 'pdf';
                    $jobImage->save();
                }
            }

            $job_images = JobImages::where('job_id', $request->job_id)->get();

            return response()->json([
                'success' => true,
                'job_images' => $job_images,
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

    public function deleteJobImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric',
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

            JobImages::where('job_id', $request->job_id)->where('id', $request->image_id)->delete();

            $job_images = JobImages::where('job_id', $request->job_id)->get();

            return response()->json([
                'success' => true,
                'job_images' => $job_images,
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

    

    public function filter_jobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required',
            'date' => 'required|date_format:Y-m-d',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            
            $date = $request->date;
            // if($request->role_id == '2'){
                $jobs = JobModel::where('date', $date)->with(['jobImages'])->get();
            // }
            // if($request->role_id == '3' || $request->role_id == '4' || $request->role_id == '5'){
            //     $jobs = JobModel::where('date', $date)->where('rigger_assigned',$request->user_id)->with(['jobImages','userAssigned'])->get();
            // }

            if(isset($jobs) && count($jobs) > 0) {
                foreach($jobs as $job){
                    $job->rigger_assigned = json_decode($job->rigger_assigned);

                    if($job->job_type == '3'){
                        $job->assigned_users = $job->user_assigned;
                        $jobs_list_new[] = $job;
                        
                    }else{
                        $riggerAssignedIds = $job->rigger_assigned;
                    
                        if (is_array($riggerAssignedIds)) {
                            $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                        } else {
                            $assignedUsers = array();
                        }
                        $job->assigned_users = implode(', ', $assignedUsers);
                        $jobs_list_new[] = $job;
                    }
                }
                return response()->json([
                    'success' => true,
                    'jobs' => $jobs,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Jobs Found',
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

    public function advance_filter_jobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $user_id = isset($request->user_id) ? $request->user_id : '';
        $role_id = isset($request->role_id) ? $request->role_id : '';
        $job_type = isset($request->job_type) ? $request->job_type : '';
        $job_category = isset($request->job_category) ? $request->job_category : '';
        $client_name = isset($request->client_name) ? $request->client_name : '';
        $address = isset($request->address) ? $request->address : '';
        $start_date = isset($request->start_date) ? $request->start_date : '';
        $end_date = isset($request->end_date) ? $request->end_date : '';
        $assigned_rigger_transporter = isset($request->assigned_rigger_transporter) ? $request->assigned_rigger_transporter : '';
        $supplier_name = isset($request->supplier_name) ? $request->supplier_name : '';
        $status = isset($request->status) ? $request->status : '';

        // Check if validation fails
        if($job_type=='' && $job_category=='' && $client_name=='' && $address=='' && 
            $start_date=='' && $end_date=='' && $assigned_rigger_transporter=='' && 
            $supplier_name=='' && $status==''){
                return response()->json([
                    'success' => false,
                    'errors' => 'Choose atleast one filter!',
                ], 422);
        }

        try {
            
            // make query for get listing
            // if($role_id == '2'){
                $query = JobModel::with(['jobImages']);
            // }else{
            //     $query = JobModel::where('rigger_assigned',$request->user_id)->with(['jobImages','userAssigned']);
            // }
            
            if ($job_type!='') {
                $query->where('job_type', $job_type);
            }

            if ($job_category!='') {
                $query->where('scci', $job_category);
            }

            if ($client_name!='') {
                $query->where('client_name', 'like', '%' . $client_name . '%');
            }

            if ($address!='') {
                $query->where('address', 'like', '%' . $address . '%');
            }

            if ($assigned_rigger_transporter!='') {
                $query->where('rigger_assigned', $assigned_rigger_transporter);
            }

            if ($supplier_name!='') {
                $query->where('supplier_name', $supplier_name);
            }

            if ($status!='') {
                $query->where('status', $status);
            }

            if ($start_date!='' && $end_date=='' ) {

                $query->whereDate('date', '>=', $start_date);
            
            }else if ($end_date!='' && $start_date=='' ) {
            
                $query->whereDate('date', '<=', $end_date);
            
            }else if ($start_date!='' && $end_date!='' ) {
            
                $query->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
            
            }

            $jobs = $query->get();
            
            if(is_countable($jobs) && count($jobs) > 0) {
                
                $jobs_list_new = [];

                foreach($jobs as $job){
                    $job->rigger_assigned = json_decode($job->rigger_assigned);

                    if($job->job_type == '3'){
                        $job->assigned_users = $job->user_assigned;
                        $jobs_list_new[] = $job;
                    }else{
                        $riggerAssignedIds = $job->rigger_assigned;
                    
                        if (is_array($riggerAssignedIds)) {
                            $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                        } else {
                            $assignedUsers = array();
                        }
                        $job->assigned_users = implode(', ', $assignedUsers);
                        $jobs_list_new[] = $job;
                    }
                }
                return response()->json([
                    'success' => true,
                    'jobs' => $jobs_list_new,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Jobs Found',
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
    

    public function getJobDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }


        try {

            // $job = JobModel::where('id', $request->job_id)->with(['jobImages','userAssigned','createdBy','updatedBy'])->first();
            // $job = JobModel::where('id', $request->job_id)->with(['jobImages','userAssigned','createdBy','updatedBy','riggerTicket','riggerTicket.ticketImages',
            //     'riggerTicket.payDuty','riggerTicket.payDuty.dutyImages',
            //     'transporterTicket','transporterTicket.ticketImages'])->first();

            $job = JobModel::where('id', $request->job_id)->with(['jobImages','createdBy','updatedBy','riggerTicket','riggerTicket.ticketImages',
                                    'riggerTicket.payDuty' => function ($query) {
                                        $query->where('status', 3)
                                            ->with(['dutyImages']);
                                    },
                                    'riggerTicket.payDuty.dutyImages',
                                    'transporterTicket','transporterTicket.ticketImages'])->first();

            if($job) {
                
                $job->rigger_assigned = $job->rigger_assigned != null ? json_decode($job->rigger_assigned) : [];
                $jobs_detail_new = null;

                
                if($job->job_type == '3'){
                    $jobs_detail_new = $job;
                }else{
                    // $riggerAssignedIds = json_decode($job->rigger_assigned, true);
                
                    if (is_array($job->rigger_assigned)) {
                        $assignedUsers = User::whereIn('id', $job->rigger_assigned)->pluck('name')->toArray();
                    } else {
                        $assignedUsers = array();
                    }
                    $job->assigned_users = implode(', ', $assignedUsers);
                    $jobs_detail_new = $job;
                }

                return response()->json([
                    'success' => true,
                    'job_detail' => $jobs_detail_new,
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


    public function changestatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $job = JobModel::where('id', $request->job_id)->first();
            if($job) {
            
                $job->status = $request->status;
                $job->save();
                
                $jobDetail = JobModel::where('id', $request->job_id)->first();
                $riggerAssignedIds = json_decode($jobDetail->rigger_assigned); 
                // $user = User::whereIn('id', $jobDetail->rigger_assigned)->get();
                $assignedUsers = User::whereIn('id', $riggerAssignedIds)->where('status', '1')->pluck('name')->toArray();
                $userNames = implode(', ', $assignedUsers);

                $createdBy = User::where('id', $jobDetail->created_by)->first();
                
                if($jobDetail->job_type == '1'){
                    $job_type = 'Logistic Job(SCCI)';  
                }else if($jobDetail->job_type == '2'){
                    $job_type = 'Crane Job';  
                }else{
                    $job_type = 'Other Job';  
                }

                if($jobDetail->status == '0'){
                    $status_txt = 'Problem';
                }else if($jobDetail->status == '1'){
                    $status_txt = 'Good To Go';
                }else if($jobDetail->status == '2'){
                    $status_txt = 'On-Hold';
                }
                
                $mailData = [];
                
                $mailData['user'] = isset($userNames) ? $userNames : '';
                $mailData['username'] = isset($userNames) ? $userNames : '';
                $mailData['job_number'] = 'J-'.$jobDetail->id;
                $mailData['job_type'] = $job_type;
                $mailData['assigned_to'] = isset($userNames) ? $userNames : '';
                $mailData['client_name'] = $jobDetail->client_name;
                $mailData['job_address'] = $jobDetail->address;
                $mailData['job_date'] = date('d M,Y', strtotime($jobDetail->date));
                $mailData['start_time'] = date('H:i A', strtotime($jobDetail->start_time));
                $mailData['end_time'] = date('H:i A', strtotime($jobDetail->end_time));
                $mailData['status'] = $status_txt;

                $mailData['text1'] = "Job status has been changed by manager/user. Job details are as under.";
                $mailData['text2'] = "For more details please contact the Manager/Admin.";

                $allUsers = User::whereIn('role_id', ['0','1','3'])->where('status', '1')->get();

                if($allUsers){
                    foreach($allUsers as $value){
                        $mailData['user'] = $value->name;
                        $body = view('emails.job_template', $mailData);
                        $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                        sendMail($value->name, $userEmailsSend, 'Superior Crane', 'Job Status Change', $body);
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Status Updated Successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Job Id',
                ], 401);
            }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error updating job status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getAssignedJobs(Request $request)
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
            $user = User::where('id', $request->user_id)->first();
            if($user->role_id == '5' || $user->role_id == '2'){
                if($request->type == '1'){
                    $jobs = JobModel::where('job_type', '2')->whereJsonContains('rigger_assigned', $request->user_id)->where('status', '1')->with(['jobImages'])
                                ->whereDoesntHave('riggerTicket')
                                ->whereDoesntHave('transporterTicket')
                                ->get();
                }else{
                    $jobs = JobModel::where('job_type', '1')->whereJsonContains('rigger_assigned', $request->user_id)->where('status', '1')->with(['jobImages'])
                                ->whereDoesntHave('riggerTicket')
                                ->whereDoesntHave('transporterTicket')
                                ->get();
                }
            }else{
                $jobs = JobModel::where('job_type','!=', '3')->whereJsonContains('rigger_assigned', $request->user_id)->where('status', '1')->with(['jobImages'])
                                        ->whereDoesntHave('riggerTicket')
                                        ->whereDoesntHave('transporterTicket')
                                        ->get();
            }
            
            if(is_countable($jobs) && count($jobs) > 0) {
                // foreach($jobs as $job){
                //     $job->rigger_assigned = json_decode($job->rigger_assigned);
                // }
                $jobs_list_new = [];

                foreach($jobs as $job){
                    $job->rigger_assigned = json_decode($job->rigger_assigned);

                    if($job->job_type == '3'){
                        $job->assigned_users = $job->user_assigned;
                        $jobs_list_new[] = $job;
                    }else{
                        $riggerAssignedIds = $job->rigger_assigned;
                    
                        if (is_array($riggerAssignedIds)) {
                            $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                        } else {
                            $assignedUsers = array();
                        }
                        $job->assigned_users = implode(', ', $assignedUsers);
                        $jobs_list_new[] = $job;
                    }
                }
                return response()->json([
                    'success' => true,
                    'jobs' => $jobs,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Jobs Found',
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

    public function viewTicketPdf(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'flag' => 'required',

        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            
            $id = $request->id;
            $flag = $request->flag;
            
            if($flag == '1'){   // rigger ticket pdf
                $pdfUrl = $this->makeRiggerTicketPdf($id);
            }else if($flag == '2'){ // transporter ticket pdf
                $pdfUrl = $this->makeTransporterTicketPdf($id);
            }else if($flag == '3'){ // payDuty pdf
                $pdfUrl = $this->makePayDutyPdf($id);
            }else{
                $pdfUrl = '';
            }
            
            $pdf_url = '/public'.$pdfUrl;

            return response()->json([
                'success' => true,
                'pdf_url' => $pdf_url,
            ], 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading jobs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function makeRiggerTicketPdf($id)
    {

        $filepath = public_path('assets/pdf/pdf_samples/rigger_ticket.pdf');
        $output_file_path = public_path('assets/pdf/rigger_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = RiggerTicket::find($id);
        if($ticket){
            $fields = [
                ['text' => 'RTKT-'.$ticket->id, 'x' => 245, 'y' => 6.5],
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

                ['base64_image' => $ticket->signature, 'x' => 55, 'y' => 182, 'width' => 30, 'height' => 14.5],
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            $publicPath = str_replace(public_path(), '', $outputFile); // Remove the public path part
            $publicUrl = url($publicPath); // Generate a full URL to the PDF file

            return $publicPath;
        }else{
            return false;
        }
    }

    public function makeTransporterTicketPdf($id)
    {

        $filepath = public_path('assets/pdf/pdf_samples/transporter_ticket.pdf');
        $output_file_path = public_path('assets/pdf/transporter_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = TransportationTicketModel::find($id);
        if($ticket){
            $fields = [
                ['text' => 'TTKT-'.$ticket->id, 'x' => 245, 'y' => 13],
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
            $publicPath = str_replace(public_path(), '', $outputFile); // Remove the public path part
            $publicUrl = url($publicPath); // Generate a full URL to the PDF file
            
            return $publicPath;
        }else{
            return false;
        }
    }
    
    public function makePayDutyPdf($id)
    {

        $filepath = public_path('assets/pdf/pdf_samples/pay_duty.pdf');
        $output_file_path = public_path('assets/pdf/pay_duty_pdfs/form_' .$id. '.pdf'); 
        $form = PayDutyModel::find($id);
        if($form){
            $fields = [
                ['text' => 'RTKT-'.$form->rigger_ticket_id, 'x' => 68, 'y' => 31],
                ['text' => 'PDTY-'.$form->id, 'x' => 167, 'y' => 31],
                ['text' => date('d-M-Y', strtotime($form->date)), 'x' => 86, 'y' => 87.5],
                ['text' => $form->location, 'x' => 86, 'y' => 105],
                ['text' => $form->start_time != null ? date('h:i', strtotime($form->start_time)) : '', 'x' => 86, 'y' => 123],
                ['text' => $form->finish_time != null ? date('h:i', strtotime($form->finish_time)) : '', 'x' => 86, 'y' => 141],

                ['text' => $form->total_hours != null ? date('h:i', strtotime($form->total_hours)) : '', 'x' => 86, 'y' => 159],
                ['text' => $form->officer, 'x' => 86, 'y' => 177],
                ['text' => $form->officer_name, 'x' => 110, 'y' => 194],
                ['text' => $form->division, 'x' => 86, 'y' => 212],
                ['base64_image' => $form->signature, 'x' => 100, 'y' => 225, 'width' => 30, 'height' => 10],
                
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            $publicPath = str_replace(public_path(), '', $outputFile); // Remove the public path part
            $publicUrl = url($publicPath); // Generate a full URL to the PDF file
            return $publicPath;
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