<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\JobModel;
use App\Models\JobImages;
use App\Models\RiggerTicket;
use App\Models\RiggerTicketImages;

use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;

use App\Models\PayDutyModel;
use App\Models\PayDutytImages;
use App\Models\InventoryModel;






class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // Use dependency injection to bring in the PaymentEncode class
    public function __construct()
    {
        
    }

    public function login(Request $request)
    {
        $data['pageTitle'] = 'Login';
        return view('admin/login')->with($data);
    }

    public function loginSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            if($user->status == 1){
                $request->session()->put('user', $user);
                // Authentication passed...
                return redirect()->intended('/dashboard');
            }else{
                $request->session()->flash('error', 'The user is not active, please contact admin.');
                return redirect('login');
            }
        }

        $request->session()->flash('error', 'The provided credentials do not match our records.');
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('login');
    }

    

    public function dashboard(Request $request)
    {
        $data['pageTitle'] = 'Dashboard';
        return view('admin/dashboard')->with($data);
    }

    public function profile(Request $request)
    {
        $data['pageTitle'] = 'Profile';
        return view('admin/profile')->with($data);
    }

    public function users(Request $request)
    {
        $data['pageTitle'] = 'Users';
        return view('admin/users')->with($data);
    }

    public function jobs(Request $request)
    {
        $data['pageTitle'] = 'Jobs';
        return view('admin/jobs')->with($data);
    }

    public function rigger_tickets(Request $request)
    {
        $data['pageTitle'] = 'Rigger_tickets';
        return view('admin/rigger_tickets')->with($data);
    }

    public function transportation(Request $request)
    {
        $data['pageTitle'] = 'Transportation';
        return view('admin/transportation')->with($data);
    }
    
    public function pay_duty(Request $request)
    {
        $data['pageTitle'] = 'Pay_duty';
        return view('admin/pay_duty')->with($data);
    }

    public function inventory(Request $request)
    {
        $data['pageTitle'] = 'Inventory';
        return view('admin/inventory')->with($data);
    }
    

    
    public function getProfilePageData(Request $request){

        $user_detail = User::where('id', Auth::user()->id)->whereIn('role_id', ['0','1'])->with(['role'])->first();
        $data['user_detail'] = $user_detail;
        
        if($user_detail){
            return response()->json(['status' => 200, 'message' => "",'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong...",'data' => '']);
        }
    }

    public function updateAdminProfile(Request $request){
        
        if($request->passwordchange_check == 1){
            $user = auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['status' => 402, 'message' => 'The old password is incorrect.']);
            }
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:50',
                'phone_number' => 'required|numeric|digits_between:7,18',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'passwordchange_check' => 'sometimes|boolean',
                'old_password' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed'
                ],
                'password_confirmation' => 'same:password',
            ], [
                'first_name.required' => 'Username field is required.',
                'first_name.max' => 'Username must be less then 50 characters.',
                'password_confirmation.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]);
        }else{
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:50',
                'phone_number' => 'required|numeric|digits_between:7,18',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'first_name.required' => 'Username field is required.',
                'first_name.max' => 'Username must be less then 50 characters.',
            ]);
        }
        
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();

        $user->name = $request->first_name;
        $user->phone_number = $request->phone_number;
        $user->updated_by = Auth::user()->id;

        if($request->passwordchange_check == 1){
            $user->password= bcrypt($request->password);
        }

        $req_file = 'profile_image';
        $path = '/assets/uploads/profile';
        
        if ($request->hasFile($req_file)) {
            
            if($user->image != null){
                deleteImage(str_replace(url('/'),"",$user->image));
            }
           
            $uploadedFile = $request->file($req_file);

            $savedImage = saveSingleImage($uploadedFile, $path);
            $user->image = url('/').$savedImage;
        }
        
        $user->save();
        return response()->json(['status' => 200, 'message' => 'Profile Updated Successfully']);
    }

    public function saveUserData(Request $request){
        
        if($request->user_id == ''){
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:100|unique:users',
                'user_role' => 'required|numeric',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed'
                ],
            ], [
                'password_confirmation.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]); 
        }else{
            if($request->password == ''){
                $validatedData = $request->validate([
                    'name' => 'required|string|max:50',
                ]);
            }else{
                $validatedData = $request->validate([
                    'name' => 'required|string|max:50',
                    'password' => [
                        'string',
                        'min:8',
                        'max:20',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                        'confirmed'
                    ],
                ], [
                    'password_confirmation.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                ]);
            }
        }
        
       
        if($request->user_id == ''){
            $user = new User();
        }else{
            $user = User::where('id', $request->user_id)->first();
        }
       
        $user->name = $request->name;
        if($request->user_id == ''){
            $user->email = $request->email;
            $user->role_id = $request->user_role;
            $user->password= bcrypt($request->password);
            $user->created_by = Auth::user()->id;
        }else{
            $user->updated_by = Auth::user()->id;
            if($request->password != ''){
                $user->password= bcrypt($request->password);
            }
        }
        
        $user->save();

        $roleName = Roles::where('id', $user->role_id)->value('role_name');

        // email send
        $mailData = [];
        $mailData['user'] = $user->name;
        $mailData['username'] = $user->name;
        $mailData['email'] = $user->email;
        $mailData['role'] = $roleName;

        if($request->user_id == ''){
            
            $mailData['text1'] = "Welcome to Superior Crane! We're thrilled to have you on board.";
            $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

            $body = view('emails.signup_welcome', $mailData);
            $userEmailsSend[] = 'hamza@5dsolutions.ae';//$user->email;

            sendMail($user->name, $userEmailsSend, 'Superior Crane', 'Register User', $body);
        }else{
            if($request->password != ''){
                
                $mailData['password'] = $request->password;
                $mailData['text1'] = "Your password is updated by admin, your login details are mention below";
                $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

                $body = view('emails.signup_welcome', $mailData);
                $userEmailsSend[] = 'hamza@5dsolutions.ae';//$user->email;

                sendMail($user->name, $userEmailsSend, 'Superior Crane', 'Change Password', $body);
            }
        }

        if($request->user_id == ''){
            return response()->json(['status' => 200, 'message' => 'User Updated Successfully']);
        }else{
            return response()->json(['status' => 200, 'message' => 'User Added Successfully']);
        }
    }

    public function getUsersPageData(Request $request){

        
        $data['admin_list'] = User::where('role_id', '1')->get();
        $data['manager_list'] = User::where('role_id', '2')->get();
        $data['users_list'] = User::whereIn('role_id', ['3','4','5'])->get();

        $data['admin_count'] = User::where('role_id', '1')->count();
        $data['manager_count'] = User::where('role_id', '2')->count();
        $data['users_count'] = User::whereIn('role_id', ['3','4','5'])->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
        
    }

    public function changeUserStatus(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->where('role_id','!=','0')->first();
        if($user){
            if($user->status == '1'){
                $user->status = '0';
            }else{
                $user->status = '1';
            }
            $user->save();

            $roleName = Roles::where('id', $user->role_id)->value('role_name');

            $mailData = [];
            $mailData['user'] = $user->name;
            $mailData['username'] = $user->name;
            $mailData['email'] = $user->email;
            $mailData['role'] = $roleName;
            $mailData['status'] = $user->status == '0' ? 'Deactive' : 'Active';

            if($user->status == '0'){
                $mailData['text1'] = "Your account is deactivated by admin, your account details are mention below";
                $subject = 'Account Deactivated';
            }else{
                $mailData['text1'] = "Your account is activated by admin, your account details are mention below";
                $subject = 'Account Activated';
            }
            
            $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

            $body = view('emails.signup_welcome', $mailData);
            $userEmailsSend[] = 'hamza@5dsolutions.ae';//$user->email;
            sendMail($user->name, $userEmailsSend, 'Superior Crane', $subject, $body);

            return response()->json(['status' => 200, 'message' => "User status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function getSpecificUserDetails(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->where('role_id','!=','0')->with(['role','createdBy','updatedBy'])->first();
        if($user){
            $data['user_detail'] = $user;
            return response()->json(['status' => 200, 'message' => "", 'data'=> $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function searchAdminListing(Request $request){
        $search_user_num = str_replace(['U','u', '-'], '', $request->user_number);
        $search_name = $request->search_name;
        $search_email = $request->search_email;
        $search_phone = $request->phone_number;
        $search_status = $request->status;
        $search_flag = $request->flag;

        if($search_user_num == '' && $search_name == '' && $search_email == '' && $search_phone == '' && $search_status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        
        if($search_flag == 'admin'){
            $query = User::where('role_id', '1');
        }
        if($search_flag == 'manager'){
            $query = User::where('role_id', '2');
        }
        if($search_flag == 'user'){
            $query = User::whereIn('role_id', ['3','4','5']);
        }
        

        if (!is_null($search_user_num)) {
            $query->where('id', $search_user_num);
        }
        if (!is_null($search_name)) {
            $query->where('name', 'like', '%' . $search_name . '%');
        }

        if (!is_null($search_email)) {
            $query->where('email', 'like', '%' . $search_email . '%');
        }

        if (!is_null($search_phone)) {
            // $query->where('phone_number', $search_phone);
            $query->where('phone_number', 'like', '%' . $search_phone . '%');
        }

        if (!is_null($search_status)) {
            $query->where('status', $search_status);
        }

        $data['listing'] = $query->get();
        $data['flag'] = $search_flag;

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function deleteSpecificUser(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->where('role_id','!=','0')->first();
        if($user){
            User::where('id', $user_id)->delete();
            return response()->json(['status' => 200, 'message' => "User deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }
    
    public function getDashboardPageData(Request $request){

        $users_list = User::whereIn('role_id', ['3','4','5'])->get();
        $data['users_list'] = $users_list;
        $data['jobs_list'] = JobModel::with(['userAssigned'])->orderBy('id','desc')->get();
        $data['total_scci'] = JobModel::where('job_type', '1')->count();
        $data['total_crane'] = JobModel::where('job_type', '2')->count();
        $data['total_other'] = JobModel::where('job_type', '3')->count();
        $data['total_jobs'] = JobModel::count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function getAllJobs(Request $request){

        
        $jobs = JobModel::all(); // Retrieve job data from the database
        $events = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->client_name,
                'start' => $job->start_time,
                'end' => $job->end_time,
                'end' => $job->end_time,
                'extendedProps' => [
                    'type' => $job->job_type,
                    'status' => $job->status,
                ],
            ];
        });
        
        return response()->json($events);
    }

    public function saveJobData(Request $request){
        
        if($request->job_id == ''){
            $validatedData = $request->validate([
                'job_type' => 'required',
                'job_time' => 'required|date_format:H:i',
                'client_name' => 'required|string|max:50',
                'equipment_to_be_used' => 'required|string|max:255',
                'rigger_assigned' => 'required|numeric',
                'date' => 'required|date',
                'address' => 'required|string|max:200',
                'start_time' => 'required|date_format:Y-m-d\TH:i',
                'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
                'supplier_name' => 'required|string|max:50',
                'notes' => 'nullable|string',
                // 'scci' => 'boolean',
                'job_images' => 'required',
                'job_images.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'job_images_title' => 'required',
                'job_images_title.*' => 'required|string|max:255',
                // 'status' => 'required',
            ]); 
        }else{
            $validatedData = $request->validate([
                'job_id' => 'required',
                'job_type' => 'required',
                'job_time' => 'required|date_format:H:i',
                'client_name' => 'required|string|max:50',
                'equipment_to_be_used' => 'required|string|max:255',
                'rigger_assigned' => 'required|numeric',
                'date' => 'required|date',
                'address' => 'required|string|max:200',
                'start_time' => 'required|date_format:Y-m-d\TH:i',
                'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
                'supplier_name' => 'required|string|max:50',
                'notes' => 'nullable|string',
                // 'job_images' => 'required',
                'job_images' => 'required|array|min:1',
                'job_images.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                // 'job_images.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                // 'job_images_title' => 'required',
                'job_images_title.*' => 'required|string|max:255',
                'status' => 'required',
            ]); 
        }
        
        if($request->job_id == ''){
            $job = new JobModel;
            $job->created_by = Auth::user()->id;
        }else{
            $job = JobModel::where('id', $request->job_id)->first();
            $job->updated_by = Auth::user()->id;

            $previousStatus = $job->status;
            $currentStatus = $request->status;
        }
        
        $job->job_type = $request->job_type;
        $job->job_time = $request->job_time;
        $job->equipment_to_be_used = $request->equipment_to_be_used;
        $job->client_name = $request->client_name;
        $job->rigger_assigned = $request->rigger_assigned;
        $job->date = $request->date;
        $job->address = $request->address;
        $job->start_time = $request->start_time;
        $job->end_time = $request->end_time;
        $job->supplier_name = $request->supplier_name;
        $job->notes = $request->notes;
        $job->status = $request->status;
        
        $job->save();

        if(isset($request->deletedFileIds) && $request->deletedFileIds != ''){
            $deletedIdsArr = explode(',', $request->deletedFileIds);
            foreach($deletedIdsArr as $index => $value){
                $JobImage = JobImages::where('id', $value)->first();
                deleteImage(str_replace(url('/public'),"",$JobImage->path));
                JobImages::where('id', $value)->delete();
            }   
        }

        $req_file = 'job_images';
        $path = '/uploads/job_images/' . $job->id;

        if ($request->hasFile($req_file)) {

            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }
            
            // $uploadedFiles = $request->file($req_file);
            $uploadedFiles = $request->job_images;
            $uploadedFilesTitle = $request->job_images_title;

            foreach ($uploadedFiles as $index => $file) {
                
                $file_title = $uploadedFilesTitle[$index];

                $file_extension = $file->getClientOriginalExtension();
                $date_append = Str::random(32);
                $file->move(public_path($path), $date_append . '.' . $file_extension);

                $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;//

                $JobImages = new JobImages();
                $JobImages->job_id = $job->id;
                $JobImages->file_name = $file_title;//$file->getClientOriginalName();
                $JobImages->path = $savedFilePaths;
                $JobImages->save();
            }
        }

        if($request->job_id == ''){
            $jobDetail = JobModel::where('id', $job->id)->first();
            $user = User::where('id', $jobDetail->rigger_assigned)->first();// assigned user details
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
                $status_txt = 'Assigned';
            }
            
            $mailData = [];
            
            $mailData['user'] = $user->name;
            $mailData['username'] = $user->name;
            $mailData['job_number'] = 'J-'.$jobDetail->id;
            $mailData['job_type'] = $job_type;
            $mailData['assigned_to'] = $user->name;
            $mailData['client_name'] = $jobDetail->client_name;
            $mailData['start_time'] = $jobDetail->start_time;
            $mailData['end_time'] = $jobDetail->end_time;
            $mailData['status'] = $status_txt;

            $mailData['text1'] = "New job has been assigned by " . $createdBy->name . ". Job details are as under.";
            $mailData['text2'] = "For more details please contact the Manager/Admin.";

            $allUsers = User::whereIn('role_id', ['0','1','2'])->where('status', '1')->where('id','!=',Auth::user()->id)->get();

            if($allUsers){
                foreach($allUsers as $value){
                    $mailData['user'] = $value->name;
                    $body = view('emails.job_template', $mailData);
                    $userEmailsSend = 'hamza@5dsolutions.ae';//$value->email;
                    sendMail($value->name, $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
                }
            }
        }else{
            if($previousStatus != $currentStatus){
                $jobDetail = JobModel::where('id', $job->id)->first();
                $user = User::where('id', $jobDetail->rigger_assigned)->first();// assigned user details
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
                    $status_txt = 'Assigned';
                }
                
                $mailData = [];
                
                $mailData['user'] = $user->name;
                $mailData['username'] = $user->name;
                $mailData['job_number'] = 'J-'.$jobDetail->id;
                $mailData['job_type'] = $job_type;
                $mailData['assigned_to'] = $user->name;
                $mailData['client_name'] = $jobDetail->client_name;
                $mailData['start_time'] = $jobDetail->start_time;
                $mailData['end_time'] = $jobDetail->end_time;
                $mailData['status'] = $status_txt;

                $mailData['text1'] = "Job status has been changed by admin. Job details are as under.";
                $mailData['text2'] = "For more details please contact the Manager/Admin.";

                $allUsers = User::whereIn('role_id', ['0','1','3'])->where('status', '1')->where('id','!=',Auth::user()->id)->get();

                if($allUsers){
                    foreach($allUsers as $value){
                        $mailData['user'] = $value->name;
                        $body = view('emails.job_template', $mailData);
                        $userEmailsSend = 'hamza@5dsolutions.ae';//$value->email;
                        sendMail($value->name, $userEmailsSend, 'Superior Crane', 'Job Status Change', $body);
                    }
                }
            }
        }

        if($request->job_id == ''){
            return response()->json(['status' => 200, 'message' => 'Job Added Successfully']);
        }else{
            return response()->json(['status' => 200, 'message' => 'Job Updated Successfully']);
        }
    }

    public function changeJobStatus(Request $request){
        $job_id = $request->job_id;
        $status = $request->status;
        $job = JobModel::where('id', $job_id)->first();
        if($job){
            $job->status = $status;
            $job->save();
            return response()->json(['status' => 200, 'message' => "Job status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function viewJobDetails(Request $request){
        $job_id = $request->job_id;
        
        $job = JobModel::where('id', $job_id)->with(['jobImages','createdBy','updatedBy'])->first();
        if($job){
            $data['job_detail'] = $job;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Job not found..."]);
        }
    }
    
    public function deleteSpecificJob(Request $request){
        $job_id = $request->job_id;
        $job = JobModel::where('id', $job_id)->with(['jobImages'])->first();
        if($job){
            $job_images = $job->job_images != null ? $job->job_images : array();
            if(count($job_images) > 0){
                foreach($job_images as $image){
                    deleteImage(str_replace(url('/public'),"",$image->path));
                    JobImages::where('id', $image->id)->delete();
                } 
            }
            JobModel::where('id', $job_id)->delete();
            return response()->json(['status' => 200, 'message' => "Job deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function searchJobsListing(Request $request){
        $search_job_no = str_replace(['J','j', '-'], '', $request->search_job_no);
        $search_client = $request->search_client;
        $search_address = $request->search_address;
        $search_job_type = $request->search_job_type;
        $search_status = $request->search_status;
        $search_date = $request->search_date;
        $search_assigned_user = $request->search_assigned_user;
        $search_supplier = $request->search_supplier;

        if($search_job_no == '' && $search_client == '' && $search_address == '' && $search_job_type == '' && $search_status == '' &&
            $search_date == '' && $search_assigned_user == '' && $search_supplier == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = JobModel::with(['userAssigned']);
        
        if ($search_job_no != '') {
            $query->where('id', $search_job_no);
        }
        if ($search_client != '') {
            $query->where('client_name', 'like', '%' . $search_client . '%');
        }
        if ($search_address != '') {
            $query->where('address', 'like', '%' . $search_address . '%');
        }
        if ($search_job_type != '') {
            $query->where('job_type', $search_job_type);
        }
        if (!is_null($search_status)) {
            $query->where('status', $search_status);
        }

        if ($search_date != '') {
            $query->whereDate('date', '=', $search_date);
        }
        if ($search_assigned_user != '') {
            $query->where('rigger_assigned', $search_assigned_user);
        }
        if ($search_supplier != '') {
            $query->where('supplier_name', 'like', '%' . $search_supplier . '%');
        }

        $data['jobs_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function getJobsPageData(Request $request){

        $users_list = User::whereIn('role_id', ['3','4','5'])->get();
        $data['users_list'] = $users_list;
        $data['jobs_list'] = JobModel::with(['userAssigned'])->orderBy('id','desc')->get();
        $data['total_scci'] = JobModel::where('job_type', '1')->count();
        $data['total_crane'] = JobModel::where('job_type', '2')->count();
        $data['total_other'] = JobModel::where('job_type', '3')->count();
        $data['total_jobs'] = JobModel::count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function getRiggerTicketPageData(Request $request){

        $data['tickets_list'] = RiggerTicket::with(['jobDetail','userDetail'])->get();
        $data['total_tickets'] = RiggerTicket::count();
        $data['total_draft'] = RiggerTicket::where('status', '1')->count();
        $data['total_completed'] = RiggerTicket::where('status', '3')->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function searchRiggerTicketListing(Request $request){
        $ticket_number = str_replace(['R','r', '-'], '', $request->search_ticket_number);
        $customer_name = $request->search_customer_name;
        $rigger_name = $request->search_rigger_name;
        $email = $request->search_email;
        $location = $request->search_location;
        $date = $request->search_date;
        $status = $request->search_status;

        if($ticket_number == '' && $customer_name == '' && $rigger_name == '' && $email == '' && $location == '' &&
            $date == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = RiggerTicket::with(['jobDetail','userDetail']);
        
        if ($ticket_number != '') {
            $query->where('id', $ticket_number);
        }
        if ($customer_name != '') {
            $query->where('customer_name', 'like', '%' . $customer_name . '%');
        }
        if ($rigger_name != '') {
            $query->whereHas('userDetail', function ($subQuery) use ($rigger_name) {
                $subQuery->where('name', 'like', '%' . $rigger_name . '%');
            });
        }
        if ($email != '') {
            $query->where('email', 'like', '%' . $email . '%');
        }
        if ($location != '') {
            $query->where('location', 'like', '%' . $location . '%');
        }
        if ($date != '') {
            $query->whereDate('date', '=', $date);
        }
        if ($status != '') {
            $query->where('status', $status);
        }

        $data['tickets_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function viewRiggerTicketDetails(Request $request){
        $ticket_id = $request->ticket_id;
        
        $ticket = RiggerTicket::where('id', $ticket_id)->with(['jobDetail','userDetail','ticketImages'])->first();
        if($ticket){
            $data['ticket_detail'] = $ticket;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Job not found..."]);
        }
    }

    public function deleteSpecificRiggerTicket(Request $request){
        $ticket_id = $request->ticket_id;
        $ticket = RiggerTicket::where('id', $ticket_id)->with(['ticketImages'])->first();
        if($ticket){
            $ticket_images = $ticket->ticket_images != null ? $ticket->ticket_images : array();
            if(count($ticket_images) > 0){
                foreach($ticket_images as $image){
                    deleteImage(str_replace(url('/public'),"",$image->path));
                    RiggerTicketImages::where('id', $image->id)->delete();
                } 
            }
            RiggerTicket::where('id', $ticket_id)->delete();
            return response()->json(['status' => 200, 'message' => "Ticket deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function getTransporterTicketPageData(Request $request){

        $data['tickets_list'] = TransportationTicketModel::with(['jobDetail','userDetail'])->get();
        $data['total_tickets'] = TransportationTicketModel::count();
        $data['total_draft'] = TransportationTicketModel::where('status', '1')->count();
        $data['total_completed'] = TransportationTicketModel::where('status', '3')->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function searchTransporterTicketListing(Request $request){
        $ticket_number = str_replace(['T','t', '-'], '', $request->search_ticket_number);
        $transporter_name = $request->search_transporter_name;
        $job_client_name = $request->search_job_client_name;
        $pickup_address = $request->search_pickup_address;
        $delivery_address = $request->search_delivery_address;
        $customer_email = $request->search_customer_email;
        $status = $request->search_status;

        if($ticket_number == '' && $transporter_name == '' && $job_client_name == '' && $pickup_address == '' && $delivery_address == '' &&
            $customer_email == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = TransportationTicketModel::with(['jobDetail','userDetail']);
        
        if ($ticket_number != '') {
            $query->where('id', $ticket_number);
        }
        if ($transporter_name != '') {
            $query->whereHas('userDetail', function ($subQuery) use ($transporter_name) {
                $subQuery->where('name', 'like', '%' . $transporter_name . '%');
            });
        }
        if ($job_client_name != '') {
            $query->whereHas('jobDetail', function ($subQuery) use ($job_client_name) {
                $subQuery->where('client_name', 'like', '%' . $job_client_name . '%');
            });
        }
        if ($pickup_address != '') {
            $query->where('pickup_address', 'like', '%' . $pickup_address . '%');
        }
        if ($delivery_address != '') {
            $query->where('delivery_address', 'like', '%' . $delivery_address . '%');
        }
        if ($customer_email != '') {
            $query->where('customer_email', 'like', '%' . $customer_email . '%');
        }
        if ($status != '') {
            $query->where('status', $status);
        }

        $data['tickets_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function viewTransporterTicketDetails(Request $request){
        $ticket_id = $request->ticket_id;
        
        $ticket = TransportationTicketModel::where('id', $ticket_id)->with(['jobDetail','userDetail','ticketImages'])->first();
        if($ticket){
            $data['ticket_detail'] = $ticket;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Job not found..."]);
        }
    }

    public function deleteSpecificTransportationTicket(Request $request){
        $ticket_id = $request->ticket_id;
        $ticket = TransportationTicketModel::where('id', $ticket_id)->with(['ticketImages'])->first();
        if($ticket){
            $ticket_images = $ticket->ticket_images != null ? $ticket->ticket_images : array();
            if(count($ticket_images) > 0){
                foreach($ticket_images as $image){
                    deleteImage(str_replace(url('/public'),"",$image->path));
                    TransportationTicketImages::where('id', $image->id)->delete();
                } 
            }
            TransportationTicketModel::where('id', $ticket_id)->delete();
            return response()->json(['status' => 200, 'message' => "Ticket deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function getPayDutyPageData(Request $request){

        $data['forms_list'] = PayDutyModel::with(['userDetail'])->get();
        $data['total_forms'] = PayDutyModel::count();
        $data['total_draft'] = PayDutyModel::where('status', '1')->count();
        $data['total_completed'] = PayDutyModel::where('status', '3')->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function searchPayDutyListing(Request $request){
        $form_number = str_replace(['P','p', '-'], '', $request->search_form_number);
        $officer_name = $request->search_officer_name;
        $officer_num = $request->search_officer_num;
        $issued_by = $request->search_issued_by;
        $date = $request->search_date;
        $location = $request->search_location;
        $division = $request->search_division;
        $status = $request->search_status;

        if($form_number == '' && $officer_name == '' && $officer_num == '' && $issued_by == '' && $date == '' &&
            $location == '' && $division == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = PayDutyModel::with(['userDetail']);
        
        if ($form_number != '') {
            $query->where('id', $form_number);
        }
        if ($issued_by != '') {
            $query->whereHas('userDetail', function ($subQuery) use ($issued_by) {
                $subQuery->where('name', 'like', '%' . $issued_by . '%');
            });
        }
        if ($officer_name != '') {
            $query->where('officer_name', 'like', '%' . $officer_name . '%');
        }
        if ($officer_num != '') {
            $query->where('officer', 'like', '%' . $officer_num . '%');
        }
        if ($date != '') {
            $query->whereDate('date', $date);
        }
        if ($location != '') {
            $query->where('location', 'like', '%' . $location . '%');
        }
        if ($division != '') {
            $query->where('division', 'like', '%' . $division . '%');
        }
        if ($status != '') {
            $query->where('status', $status);
        }

        $data['forms_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function viewPayDutyFormDetails(Request $request){
        $form_id = $request->form_id;
        
        $form = PayDutyModel::where('id', $form_id)->with(['userDetail','dutyImages'])->first();
        if($form){
            $data['payduty_detail'] = $form;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Job not found..."]);
        }
    }

    public function deleteSpecificPayDutyForm(Request $request){
        $form_id = $request->form_id;
        $form = PayDutyModel::where('id', $form_id)->with(['dutyImages'])->first();
        if($form){
            $duty_images = $form->duty_images != null ? $form->duty_images : array();
            if(count($duty_images) > 0){
                foreach($duty_images as $image){
                    deleteImage(str_replace(url('/public'),"",$image->path));
                    PayDutytImages::where('id', $image->id)->delete();
                } 
            }
            PayDutyModel::where('id', $form_id)->delete();
            return response()->json(['status' => 200, 'message' => "Pay Duty Form deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }


    public function getInventoryPageData(Request $request){

        $data['inventory_list'] = InventoryModel::get();
        $data['total_inventory'] = InventoryModel::count();
        $data['total_active'] = InventoryModel::where('status', '1')->count();
        $data['total_inactive'] = InventoryModel::where('status', '0')->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function searchInventoryListing(Request $request){
        $inventory_number = str_replace(['I','i', '-'], '', $request->search_inventory_number);
        $customer = $request->search_customer;
        $site_address = $request->search_site_address;
        $inventory_location = $request->search_inventory_location;
        $date_received = $request->search_date_received;
        $date_shipped = $request->search_date_shipped;
        $items = $request->search_items;
        $status = $request->search_status;

        if($inventory_number == '' && $customer == '' && $site_address == '' && $inventory_location == '' && $date_received == '' &&
            $date_shipped == '' && $items == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = InventoryModel::query();
        
        if ($inventory_number != '') {
            $query->where('id', $inventory_number);
        }
        
        if ($customer != '') {
            $query->where('customer_name', 'like', '%' . $customer . '%');
        }
        if ($site_address != '') {
            $query->where('site_address', 'like', '%' . $site_address . '%');
        }
        if ($inventory_location != '') {
            $query->where('inventory_location', 'like', '%' . $inventory_location . '%');
        }
        if ($date_received != '') {
            $query->whereDate('date_received', $date_received);
        }
        if ($date_shipped != '') {
            $query->whereDate('date_shipped', $date_shipped);
        }
        if ($items != '') {
            $query->where('items', 'like', '%' . $items . '%');
        }
               
        if ($status != '') {
            $query->where('status', $status);
        }

        $data['inventory_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function saveInventoryData(Request $request){
        
        $validatedData = $request->validate([
            'customer_name' => 'required|max:100',
            'site_address' => 'required|max:100',
            'items' => 'required|max:50',
            'pieces' => 'required|max:500',
            'location' => 'required|max:200',
            'date_received' => 'required|date',
            'date_shipped' => 'required|date',
            'days_in_yard' => 'required|numeric|digits_between:1,10',
            'offload_equipment' => 'max:100',
            'dimension' => 'required|numeric|digits_between:1,10',
            'square_feet' => 'required|numeric|digits_between:1,10',
            'status' => 'required|numeric',
            // 'comment' => 'required|string|max:100',
            
        ]); 
        
       
        if($request->inventory_id == ''){
            $Inventory = new InventoryModel();
        }else{
            $Inventory = InventoryModel::where('id', $request->inventory_id)->first();
        }
        
        $Inventory->customer_name = $request->customer_name;
        $Inventory->site_address = $request->site_address;
        $Inventory->items = $request->items;
        $Inventory->pieces = $request->pieces;
        $Inventory->inventory_location = $request->location;
        $Inventory->date_received = $request->date_received;
        $Inventory->date_shipped = $request->date_shipped;
        $Inventory->days_in_yard = $request->days_in_yard;

        $Inventory->offload_equipment = $request->offload_equipment;
        $Inventory->dimension = $request->dimension;
        $Inventory->size_sq_feet = $request->square_feet;
        $Inventory->comment = $request->comment;
        $Inventory->status= $request->status;

        if($request->inventory_id == ''){
            $Inventory->created_by = Auth::user()->id;
            $Inventory->created_at = date('Y-m-d H:i:s');
        }else{
            $Inventory->updated_by= Auth::user()->id;
            $Inventory->updated_at= date('Y-m-d H:i:s');
        }
        
        $Inventory->save();

        if($request->inventory_id == ''){
            return response()->json(['status' => 200, 'message' => 'Inventory Updated Successfully']);
        }else{
            return response()->json(['status' => 200, 'message' => 'Inventory Added Successfully']);
        }
    }

    public function getSpecificInventoryDetails(Request $request){
        $inventory_id = $request->inventory_id;
        
        $inventory = InventoryModel::where('id', $inventory_id)->first();
        if($inventory){
            $data['inventory_detail'] = $inventory;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Job not found..."]);
        }
    }

    public function deleteSpecificInventory(Request $request){
        $inventory_id = $request->inventory_id;
        $inventory = InventoryModel::where('id', $inventory_id)->first();
        if($inventory){
            InventoryModel::where('id', $inventory_id)->delete();
            return response()->json(['status' => 200, 'message' => "Inventory deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }









    public function sendtomailRigger(Request $request)
    {


        $id = '14';
        $filepath = public_path('assets/pdf/pdf_samples/rigger_ticket.pdf');
        $output_file_path = public_path('assets/pdf/rigger_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = RiggerTicket::find($id);
        if($ticket){
            $fields = [
                ['text' => $ticket->id, 'x' => 245, 'y' => 6.5],
                ['text' => $ticket->specifications_remarks, 'x' => 128, 'y' => 58, 'width' => 138, 'height' => 6],
                
                ['text' => $ticket->customer_name, 'x' => 14, 'y' => 94],
                ['text' => $ticket->location, 'x' => 99, 'y' => 94],
                ['text' => $ticket->po_number, 'x' => 226, 'y' => 94],
                ['text' => date('d-M-Y', strtotime($ticket->date)), 'x' => 14, 'y' => 106],
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

                ['text' => $ticket->signature, 'x' => 40, 'y' => 187],
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            $publicPath = str_replace(public_path(), '', $outputFile); // Remove the public path part
            $publicUrl = url($publicPath); // Generate a full URL to the PDF file
            return response()->json([
                'success' => true,
                'outputFile' => $publicPath,
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
