<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
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
use App\Models\Notifications;

use App\Models\EmailSetting;
use App\Models\ArchiveService;
use App\Models\ArchiveJob;
use App\Models\ArchiveRiggerTicket;
use App\Models\ArchiveTransportationTicket;
use App\Models\ArchivePayDutyForm;


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
    
    public function notification(Request $request)
    {
        $data['pageTitle'] = 'Notification';
        return view('admin/notification')->with($data);
    }

    public function email_settings(Request $request)
    {
        $data['pageTitle'] = 'Email Settings';
        $data['settings'] = EmailSetting::find('1');
        return view('admin/email_settings')->with($data);
    }
    
    public function api_settings(Request $request)
    {
        $data['pageTitle'] = 'API Settings';
        $data['api_record_limit'] = env('API_RECORD_LIMIT');
        return view('admin/api_settings')->with($data);
    }

    public function archive_services(Request $request)
    {
        $data['pageTitle'] = 'Archive Services';
        return view('admin/archive_services')->with($data);
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
                'user_role' => 'required|numeric',
                'name' => 'required|string|max:50',
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    'unique:users',
                    'regex:/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Z]{2,}$/i'
                ],
                'phone_number' => 'required|numeric|digits_between:7,18',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed'
                ],
            ], [
                'email.regex' => 'The email must be a valid email address with a proper domain.',
                'password_confirmation.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]); 
        }else{
            if($request->password == '' && $request->password_confirmation == ''){
                $validatedData = $request->validate([
                    'name' => 'required|string|max:50',
                    'phone_number' => 'required|numeric|digits_between:7,18',
                ]);
            }else{
                $validatedData = $request->validate([
                    'name' => 'required|string|max:50',
                    'phone_number' => 'required|numeric|digits_between:7,18',
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
            }
        }
        
        if($request->user_id == ''){
            $user = new User();
        }else{
            $user = User::where('id', $request->user_id)->first();
        }
       
        $user->name = ucwords(strtolower($request->name));
        $user->phone_number = $request->phone_number;
        
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
        $mailData['phone_num'] = $user->phone_number;
        $mailData['role'] = $roleName;

        if($request->user_id == ''){
            
            $mailData['text1'] = "Welcome to Superior Crane! We're thrilled to have you on board.";
            $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

            $body = view('emails.signup_welcome', $mailData);
            $userEmailsSend[] = $user->email;//'hamza@5dsolutions.ae';//

            sendMail($user->name, $userEmailsSend, 'Superior Crane', 'Register User', $body);
        }else{
            if($request->password != ''){
                
                $mailData['password'] = $request->password;
                $mailData['text1'] = "Your password is updated by admin, your login details are mention below";
                $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

                $body = view('emails.signup_welcome', $mailData);
                $userEmailsSend[] = $user->email;//'hamza@5dsolutions.ae';//

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
            $mailData['phone_num'] = $user->phone_number;
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
            $userEmailsSend[] = $user->email;//'hamza@5dsolutions.ae';//
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
        

        if ($search_user_num != '') {
            $query->where('id', $search_user_num);
        }
        if ($search_name != '') {
            $query->where('name', 'like', '%' . $search_name . '%');
        }

        if ($search_email != '') {
            $query->where('email', 'like', '%' . $search_email . '%');
        }

        if ($search_phone != '') {
            // $query->where('phone_number', $search_phone);
            $query->where('phone_number', 'like', '%' . $search_phone . '%');
        }

        if ($search_status != '') {
            $query->where('status', $search_status);
        }

        $data['listing'] = $query->get();
        $data['flag'] = $search_flag;

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function deleteSpecificUser(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->where('role_id','!=','0')->first();
        
        $jobsCount = JobModel::where('rigger_assigned', $user->id)->count();
        if($jobsCount > 0){
            return response()->json(['status' => 402, 'message' => "Unable to delete. There is a job assigned to this user."]);
        }

        $jobsCount1 = JobModel::where('created_by', $user->id)->count();
        if($jobsCount1 > 0){
            return response()->json(['status' => 402, 'message' => "Unable to delete. There is a job linked with this user."]);
        }
        
        if($user){
            User::where('id', $user_id)->delete();
            return response()->json(['status' => 200, 'message' => "User deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }
    
    public function getDashboardPageData(Request $request){

        $jobs_list_new = [];
        $jobs_list = JobModel::orderBy('id','desc')->get();
        if($jobs_list){
            foreach ($jobs_list as $index => $value) {
                $riggerAssignedIds = json_decode($value->rigger_assigned, true);
            
                if (is_array($riggerAssignedIds)) {
                    $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                } else {
                    $assignedUsers = array();
                }
                $value->user_assigned = implode(', ', $assignedUsers);
                $jobs_list_new[] = $value;
            }
        }
        // dd($jobs_list_new);
        $users_list = User::whereIn('role_id', ['2','3','4','5'])->get();
        $data['users_list'] = $users_list;
        $data['jobs_list'] = $jobs_list_new;
        $data['total_scci'] = JobModel::where('job_type', '1')->count();
        $data['total_crane'] = JobModel::where('job_type', '2')->count();
        $data['total_other'] = JobModel::where('job_type', '3')->count();
        $data['total_crane_logistic'] = JobModel::where('job_type', '4')->count();
        $data['total_jobs'] = JobModel::count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function getAllJobs(Request $request){

        
        $jobs = JobModel::with(['userAssigned'])->get(); // Retrieve job data from the database
        // dd($jobs);
        $events = $jobs->map(function ($job) {
            if(isset($job->userAssigned->role_id) && $job->userAssigned->role_id == 2){
                $role = 'M-';
            }else if(isset($job->userAssigned->role_id) && $job->userAssigned->role_id == 3){
                $role = 'R-';
            }else if(isset($job->userAssigned->role_id) && $job->userAssigned->role_id == 4){
                $role = 'T-';
            }else if(isset($job->userAssigned->role_id) && $job->userAssigned->role_id == 5){
                $role = 'RT-';
            }else{
                $role = '';
            }
            
            if($job->user_assigned != null){
                $riggerCount = $job->user_assigned;
            }else{
                $riggerArray = json_decode($job->rigger_assigned);
            
                if (is_countable($riggerArray)) {
                    $riggerCount = 'Assigned Users:'.count($riggerArray);
                } else {
                    $riggerCount = $job->user_assigned;
                }
            }
            
            return [
                'id' => $job->id,
                'title' => substr($job->client_name, 0, 7) . '/' . $job->address,
                'start' => $job->date.' '.$job->start_time,
                'end' => $job->date.' '.$job->end_time,
                // 'extendedProps' => [
                //     'title_full' => date('H:i', strtotime($job->start_time)) . ' ' . 
                //                         $job->client_name . '/' . $job->address . '/' . 
                //                         $job->equipment_to_be_used . '/' . $role.''.$job->rigger_assigned,
                //     'type' => $job->job_type,
                //     'status' => $job->status,
                // ],
                'extendedProps' => [
                    'title_full' => date('H:i', strtotime($job->start_time)) . ' ' . 
                                        $job->client_name . '/' . $job->address . '/' . 
                                        $job->equipment_to_be_used . '/' . $riggerCount,
                    'type' => $job->job_type,
                    'status' => $job->status,
                ],
            ];
        });
        
        return response()->json($events);
    }

    public function saveJobData(Request $request){
        
        // dd($request->all());
        $request->merge([
            'start_time' => $request->input('start_time') != '' ? date('H:i', strtotime($request->input('start_time'))) : '',
            'end_time' => $request->input('end_time') != '' ? date('H:i', strtotime($request->input('end_time'))) : '',
        ]);
        if($request->job_id == ''){
            $validatedData = $request->validate([
                'job_type' => 'required',
                // 'job_time' => 'required|date_format:H:i',
                'client_name' => 'required|string|max:50',
                // 'date' => 'required|date',
                'date' => ['required', 'date_format:Y-m-d', 'regex:/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/'],
                'start_time' => 'required|date_format:H:i',
                // 'end_time' => 'required|date_format:H:i',
                'address' => 'required|string|max:200',
                'equipment_to_be_used' => 'required_unless:job_type,3|max:255',
                'rigger_assigned' => 'required_unless:job_type,3|array',
                'user_assigned' => 'max:50',
                'supplier_name' => 'max:50',
                'driver_instructions' => 'required_if:job_type,4',
                'notes' => 'nullable|string',
                // 'scci' => 'boolean',
                // 'job_images' => 'required',
                'job_images.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                // 'job_images_title' => 'required',
                'job_images_title.*' => 'string|max:255',
                // 'status' => 'required',
            ], [
                'rigger_assigned.required_unless' => 'Assigned User field is required.',
                'driver_instructions.required_if' => 'Driver Instruction field is required.',
                'job_images.required' => 'Job attachment is required.',
                'job_images.*.required' => 'Job attachment is required.',
                'job_images.*.mimes' => 'Job attachment must be a file of type: jpeg, png, jpg, gif, svg, pdf.',
                'job_images.*.max' => 'Job attachment may not be greater than 2048 kilobytes.',
                'job_images_title.required' => 'Job attachment title is required.',
                'job_images_title.*.required' => 'Job attachment title is required.',
                'job_images_title.*.string' => 'Job attachment title must be a string.',
                'job_images_title.*.max' => 'Job attachment title may not be greater than 255 characters.',
            ]); 
        }else{
            $validatedData = $request->validate([
                'job_id' => 'required',
                'job_type' => 'required',
                // 'job_time' => 'required|date_format:H:i',
                'client_name' => 'required|string|max:50',
                'date' => ['required', 'date_format:Y-m-d', 'regex:/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/'],
                'start_time' => 'required|date_format:H:i',
                // 'end_time' => 'required|date_format:H:i|after:start_time',
                'address' => 'required|string|max:200',
                'equipment_to_be_used' => 'required_unless:job_type,3|max:255',
                'rigger_assigned' => 'required_unless:job_type,3|array',
                'user_assigned' => 'max:50',
                'supplier_name' => 'max:50',
                'driver_instructions' => 'required_if:job_type,4',
                'notes' => 'nullable|string',
                // 'job_images.*' => 'required',
                'job_images.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                // 'job_images_title' => 'required',
                'job_images_title.*' => 'string|max:255',
                'status' => 'required',
            ], [
                'rigger_assigned.required_unless' => 'Assigned User field is required.',
                'driver_instructions.required_if' => 'Driver Instruction field is required.',
                'job_images.*.required' => 'Job attachment is required.',
                'job_images.*.mimes' => 'Job attachment must be a file of type: jpeg, png, jpg, gif, svg, pdf.',
                'job_images.*.max' => 'Job attachment may not be greater than 2048 kilobytes.',
                'job_images_title.*.required' => 'Job attachment title is required.',
                'job_images_title.*.string' => 'Job attachment title must be a string.',
                'job_images_title.*.max' => 'Job attachment title may not be greater than 255 characters.',
            ]); 
            
            $imageTitlesArray = $request->input('job_images_title');
            
            if(isset($imageTitlesArray[0]) && $imageTitlesArray[0] != ''){
                if(!$request->hasFile('job_images')){
                    return response()->json(['status' => 402, 'message' => 'The job attachment field is required.']);
                }
            }
        }

        if($request->job_type == '1'){
            if(count($request->rigger_assigned) > 1){
                return response()->json(['status' => 402, 'message' => 'Please assign only one transporter when job type is SCCI.']);
            }
        }
        
        if($request->job_id == ''){
            $job = new JobModel;
            $job->status = '1';     // 2=>on hold , 1=>goodtogo , 3=>complete
            $job->created_by = Auth::user()->id;
        }else{
            $job = JobModel::where('id', $request->job_id)->first();
            
            $previousStatus = $job->status;
            $currentStatus = $request->status;

            $job->status = $request->status;
            $job->updated_by = Auth::user()->id;
        }
        
        $job->job_type = $request->job_type;
        // $job->job_time = $request->job_time;
        $job->equipment_to_be_used = $request->equipment_to_be_used;
        $job->client_name = $request->client_name;
        $job->rigger_assigned = json_encode($request->rigger_assigned);
        $job->user_assigned = $request->user_assigned;
        $job->date = $request->date;
        $job->address = $request->address;
        $job->start_time = $request->start_time;
        // $job->end_time = $request->end_time;
        $job->supplier_name = $request->supplier_name;
        $job->driver_instructions = $request->driver_instructions;
        $job->notes = $request->notes;
        $job->save();

        if(isset($request->deletedFileIds) && $request->deletedFileIds != ''){
            $deletedIdsArr = explode(',', $request->deletedFileIds);
            foreach($deletedIdsArr as $index => $value){
                $JobImage = JobImages::where('id', $value)->first();
                deleteImage(str_replace(url('/'),"",$JobImage->path));
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
                // $savedFilePaths = $path . '/' . $date_append . '.' . $file_extension;

                $JobImages = new JobImages();
                $JobImages->job_id = $job->id;
                $JobImages->file_name = $file_title;
                $JobImages->type = strtolower($file_extension);//$file->getClientOriginalName();
                $JobImages->path = $savedFilePaths;
                $JobImages->save();
            }
        }

        if($request->job_id == ''){
            $jobDetail = JobModel::where('id', $job->id)->first();
            $riggerAssignedIds = json_decode($jobDetail->rigger_assigned);
            $users = User::whereIn('id', $riggerAssignedIds != null ? $riggerAssignedIds : [])->get();
            $assignedUsers = User::whereIn('id', $riggerAssignedIds != null ? $riggerAssignedIds : [])->pluck('name')->toArray();
            $userNames = implode(', ', $assignedUsers);
            $createdBy = User::where('id', $jobDetail->created_by)->first();
            // dd($assignedUsers);
            
            if($jobDetail->job_type == '1'){
                $job_type = 'Logistic Job(SCCI)';  
            }else if($jobDetail->job_type == '2'){
                $job_type = 'Crane Job';  
            }else if($jobDetail->job_type == '4'){
                $job_type = 'Crane & Logistics Job';  
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
            
            $mailData['user'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
            $mailData['username'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
            $mailData['job_number'] = 'J-'.$jobDetail->id;
            $mailData['job_type'] = $job_type;
            $mailData['assigned_to'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
            $mailData['client_name'] = $jobDetail->client_name;
            $mailData['start_time'] = date('H:i A', strtotime($jobDetail->start_time));
            // $mailData['end_time'] = $jobDetail->end_time;
            $mailData['job_date'] = date('d M,Y', strtotime($jobDetail->date));
            $mailData['job_address'] = $jobDetail->address;
            $mailData['status'] = $status_txt;

            $mailData['text1'] = "New job has been assigned by " . $createdBy->name . ". Job details are as under.";
            $mailData['text2'] = "For more details please contact the Manager/Admin.";

            if($jobDetail->job_type != 3){
                foreach($users as $user){
                    $mailData['user'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $mailData['username'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $mailData['assigned_to'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                    $body = view('emails.job_template', $mailData);
                    $userEmailsSend = $user->email;//'hamza@5dsolutions.ae';//
                    sendMail(isset($user->name) ? $user->name : $jobDetail->user_assigned, $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
                }
            }

            // $allUsers = User::whereIn('role_id', ['0','1','2'])->where('status', '1')->where('id','!=',Auth::user()->id)->get();

            // if($allUsers){
            //     foreach($allUsers as $value){
            //         $mailData['user'] = $value->name;
            //         $body = view('emails.job_template', $mailData);
            //         $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
            //         sendMail($value->name, $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
            //     }
            // }

            // push notification entry
            $Notifications = new Notifications();
            $Notifications->module_code = 'JOB CREATION';
            $Notifications->from_user_id = $createdBy->id;
            $Notifications->to_user_id = '1';
            $Notifications->subject = 'Assigned a new '. $job_type;
            if($jobDetail->job_type != 3){
                $Notifications->message = 'Job J-'.$jobDetail->id.' on '.date('d-M-Y', strtotime($jobDetail->date)).' at '.date('H:i A', strtotime($jobDetail->job_time)).' has been assigned to '. isset($userNames) ? $userNames : $jobDetail->user_assigned .'.';
            }else{
                $Notifications->message = 'Job J-'.$jobDetail->id.' on '.date('d-M-Y', strtotime($jobDetail->date)).' at '.date('H:i A', strtotime($jobDetail->job_time)).' has been assigned to '. $jobDetail->user_assigned .'.';
            }
            $Notifications->message_html = $body;
            $Notifications->read_flag = '0';
            $Notifications->created_by = $createdBy->id;
            $Notifications->created_at = date('Y-m-d H:i:s');
            $Notifications->save();

        }else{
            // dd($previousStatus.'|'.$currentStatus);
            if($previousStatus != $currentStatus){
                
                $jobDetail = JobModel::where('id', $job->id)->first();
                $riggerAssignedIds = json_decode($jobDetail->rigger_assigned);
                $users = User::whereIn('id', $riggerAssignedIds)->get();
                $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                $userNames = implode(', ', $assignedUsers);
                $createdBy = User::where('id', $jobDetail->created_by)->first();
                
                if($jobDetail->job_type == '1'){
                    $job_type = 'Logistic Job(SCCI)';  
                }else if($jobDetail->job_type == '2'){
                    $job_type = 'Crane Job';  
                }else if($jobDetail->job_type == '4'){
                    $job_type = 'Crane & Logistics Job';  
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
                
                $mailData['user'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                $mailData['username'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                $mailData['job_number'] = 'J-'.$jobDetail->id;
                $mailData['job_type'] = $job_type;
                $mailData['assigned_to'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                $mailData['client_name'] = $jobDetail->client_name;
                $mailData['start_time'] = $jobDetail->start_time;
                // $mailData['end_time'] = $jobDetail->end_time;
                $mailData['job_date'] = date('d M,Y', strtotime($jobDetail->date));
                $mailData['job_address'] = $jobDetail->address;
                $mailData['status'] = $status_txt;

                $mailData['text1'] = "Job status has been changed by admin. Job details are as under.";
                $mailData['text2'] = "For more details please contact the Manager/Admin.";

                if($jobDetail->job_type != 3){
                    foreach($users as $user){
                        $mailData['user'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                        $mailData['username'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                        $mailData['assigned_to'] = isset($user->name) ? $user->name : $jobDetail->user_assigned;
                        $body = view('emails.job_template', $mailData);
                        $userEmailsSend = $user->email;//'hamza@5dsolutions.ae';//
                        sendMail(isset($user->name) ? $user->name : $jobDetail->user_assigned, $userEmailsSend, 'Superior Crane', 'Job Creation', $body);
                    }
                }

                // $allUsers = User::whereIn('role_id', ['0','1','3'])->where('status', '1')->where('id','!=',Auth::user()->id)->get();

                // if($allUsers){
                //     foreach($allUsers as $value){
                //         $mailData['user'] = $value->name;
                //         $body = view('emails.job_template', $mailData);
                //         $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                //         sendMail($value->name, $userEmailsSend, 'Superior Crane', 'Job Status Change', $body);
                //     }
                // }
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
        
        $job = JobModel::where('id', $job_id)
                        ->with(['jobImages','createdBy','updatedBy','riggerTicket','riggerTicket.ticketImages',
                                'riggerTicket.payDuty','riggerTicket.payDuty.dutyImages',
                                'transporterTicket','transporterTicket.ticketImages'])->first();
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

        $existCount = RiggerTicket::where('job_id', $job->id)->count();
        if($existCount > 0){
            return response()->json(['status' => 402, 'message' => "Unable to delete. There is a rigger ticket linked with this job."]);
        }

        $existCount1 = TransportationTicketModel::where('job_id', $job->id)->count();
        if($existCount1 > 0){
            return response()->json(['status' => 402, 'message' => "Unable to delete. There is a transporter ticket linked with this job."]);
        }
        
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
        $search_from_date = $request->search_from_date;
        $search_to_date = $request->search_to_date;
        $search_assigned_user = $request->search_assigned_user;
        $search_supplier = $request->search_supplier;

        if($search_job_no == '' && $search_client == '' && $search_address == '' && $search_job_type == '' && $search_status == '' &&
            $search_from_date == '' && $search_to_date == '' && $search_assigned_user == '' && $search_supplier == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        if ($search_from_date != '' && $search_to_date != '') {
            if (strtotime($search_from_date) > strtotime($search_to_date)) {
                return response()->json(['status' => 402, 'message' => 'From date must be earlier than To date!']);
            }
        }

        $query = JobModel::query();
        
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

        if ($search_from_date != '' && $search_to_date == '') {

            $query->whereDate('date', '>=', $search_from_date);

        }else if ($search_from_date == '' && $search_to_date != '') {

            $query->whereDate('date', '<=', $search_to_date);

        }else if($search_from_date != '' && $search_to_date != ''){

            $query->whereDate('date', '>=', $search_from_date);
            $query->whereDate('date', '<=', $search_to_date);
        }

        if ($search_assigned_user != '') {
            // $query->whereJsonContains('rigger_assigned', $search_assigned_user);
            $query->whereJsonContains('rigger_assigned', (string) $search_assigned_user);
        }
        if ($search_supplier != '') {
            $query->where('supplier_name', 'like', '%' . $search_supplier . '%');
        }

        $jobs_list_new = [];
        $jobs_list = $query->get();
        if($jobs_list){
            foreach ($jobs_list as $index => $value) {
                if($value->job_type == '3'){
                    $jobs_list_new[] = $value;
                }else{
                    $riggerAssignedIds = json_decode($value->rigger_assigned, true);
            
                    if (is_array($riggerAssignedIds)) {
                        $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                    } else {
                        $assignedUsers = array();
                    }
                    $value->user_assigned = implode(', ', $assignedUsers);
                    $jobs_list_new[] = $value;
                }
            }
        }

        $data['jobs_list'] = $jobs_list;

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function getJobsPageData(Request $request){

        $jobs_list_new = [];
        $jobs_list = JobModel::orderBy('id','desc')->get();
        if($jobs_list){
            foreach ($jobs_list as $index => $value) {
                if($value->job_type == '3'){
                    $jobs_list_new[] = $value;
                }else{
                    $riggerAssignedIds = json_decode($value->rigger_assigned, true);
                
                    if (is_array($riggerAssignedIds)) {
                        $assignedUsers = User::whereIn('id', $riggerAssignedIds)->pluck('name')->toArray();
                    } else {
                        $assignedUsers = array();
                    }
                    $value->user_assigned = implode(', ', $assignedUsers);
                    $jobs_list_new[] = $value;
                }
            }
        }
        $users_list = User::whereIn('role_id', ['2','3','4','5'])->get();
        $data['users_list'] = $users_list;
        $data['jobs_list'] = $jobs_list_new;
        $data['total_scci'] = JobModel::where('job_type', '1')->count();
        $data['total_crane'] = JobModel::where('job_type', '2')->count();
        $data['total_other'] = JobModel::where('job_type', '3')->count();
        $data['total_crane_logistic'] = JobModel::where('job_type', '4')->count();
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
        $from_date = $request->search_from_date;
        $to_date = $request->search_to_date;
        $status = $request->search_status;

        if($ticket_number == '' && $customer_name == '' && $rigger_name == '' && $email == '' && $location == '' &&
            $from_date == '' && $to_date == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        if ($from_date != '' && $to_date != '') {
            if (strtotime($from_date) > strtotime($to_date)) {
                return response()->json(['status' => 402, 'message' => 'From date must be earlier than To date!']);
            }
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
        
        if ($from_date != '' && $to_date == '') {

            $query->whereDate('date', '>=', $from_date);

        }else if ($from_date == '' && $to_date != '') {

            $query->whereDate('date', '<=', $to_date);

        }else if ($from_date != '' && $to_date != '') {

            $query->whereDate('date', '>=', $from_date);
            $query->whereDate('date', '<=', $to_date);
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

        $existCount = PayDutyModel::where('rigger_ticket_id', $ticket->id)->count();
        if($existCount > 0){
            return response()->json(['status' => 402, 'message' => "Unable to delete. There is a pay duty form linked with this ticket."]);
        }

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
        $job_from_date = $request->search_job_from_date;
        $job_to_date = $request->search_job_to_date;


        if($ticket_number == '' && $transporter_name == '' && $job_client_name == '' && $pickup_address == '' && $delivery_address == '' &&
            $customer_email == '' && $status == '' && $job_from_date == '' && $job_to_date == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        if ($job_from_date != '' && $job_to_date != '') {
            if (strtotime($job_from_date) > strtotime($job_to_date)) {
                return response()->json(['status' => 402, 'message' => 'Job From Date must be earlier than Job To Date!']);
            }
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

        if ($job_from_date != '' && $job_to_date == '') {
            $query->whereHas('jobDetail', function ($subQuery) use ($job_from_date) {
                $subQuery->where('date', '>=', $job_from_date);
            });
        }
        if ($job_from_date == '' && $job_to_date != '') {
            $query->whereHas('jobDetail', function ($subQuery) use ($job_to_date) {
                $subQuery->where('date', '<=', $job_to_date);
            });
        }
        if ($job_from_date != '' && $job_to_date != '') {
            $query->whereHas('jobDetail', function ($subQuery) use ($job_from_date) {
                $subQuery->where('date', '>=', $job_from_date);
            });
            $query->whereHas('jobDetail', function ($subQuery) use ($job_to_date) {
                $subQuery->where('date', '<=', $job_to_date);
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
        $from_date = $request->search_from_date;
        $to_date = $request->search_to_date;
        $location = $request->search_location;
        $division = $request->search_division;
        $status = $request->search_status;

        if($form_number == '' && $officer_name == '' && $officer_num == '' && $issued_by == '' && 
            $from_date == '' && $to_date == '' && $location == '' && $division == '' && $status == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        if ($from_date != '' && $to_date != '') {
            if (strtotime($from_date) > strtotime($to_date)) {
                return response()->json(['status' => 402, 'message' => 'From date must be earlier than To date!']);
            }
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
        
        if ($from_date != '' && $to_date == '') {

            $query->whereDate('date', '>=', $from_date);

        }else if ($from_date == '' && $to_date != '') {

            $query->whereDate('date', '<=', $to_date);

        }else if($from_date != '' && $to_date != ''){

            $query->whereDate('date', '>=', $from_date);
            $query->whereDate('date', '<=', $to_date);
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
            'date_received' => 'required|date|after:date_shipped',
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

    public function getNotificationsPageData(Request $request){

        $data['notifications_list'] = Notifications::with(['fromUser'])->orderBy('created_at', 'desc')->get();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }

    public function searchNotificationsListing(Request $request){
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $read_flag = $request->read_flag;
        $from_username = $request->from_username;

        if($date_from == '' && $date_to == '' && $read_flag == '' && $from_username == ''){
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = Notifications::with(['fromUser'])->orderBy('created_at', 'desc');
        
        if ($date_from != '') {
            $query->whereDate('created_at','>=', $date_from);
        }

        if ($date_to != '') {
            $query->whereDate('created_at','<=', $date_to);
        }

        if ($read_flag != '') {
            $query->where('read_flag', $read_flag);
        }

        if ($from_username != '') {
            $query->whereHas('fromUser', function ($subQuery) use ($from_username) {
                $subQuery->where('name', 'like', '%' . $from_username . '%');
            });
        }
        
        $data['notifications_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function markNotificationRead(Request $request){
        $notification_id = $request->notification_id;
        $Notification = Notifications::where('id', $notification_id)->first();
        $Notification->read_flag = '1';
        $Notification->save();
        return response()->json(['status' => 200, 'message' => ""]);
        
    }

    public function changeRiggerTicketStatus(Request $request){
        $ticket_id = $request->ticket_id;
        $status = $request->status;
        $reason = isset($request->reason) ? $request->reason : '';

        $ticket = RiggerTicket::where('id', $ticket_id)->first();
        $payDutyCount = PayDutyModel::where('rigger_ticket_id', $ticket->id)->where('status', 3)->count();
        
        if($payDutyCount){
            return response()->json(['status' => 402, 'message' => "First change status of Pay Duty Form linked with this ticket."]);
        }
        if($ticket){
            $ticket->change_status_reason = $reason;
            $ticket->status = $status;
            $ticket->save();
            // change status of job related to ticket
            $job = JobModel::where('id', $ticket->job_id)->first();
            if($job){
                $job->status = '1';
                $job->save();
            }
            return response()->json(['status' => 200, 'message' => "Ticket status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function changePayDutyStatus(Request $request){
        $payduty_id = $request->payduty_id;
        $status = $request->status;
        $reason = isset($request->reason) ? $request->reason : '';
        
        $payDuty = PayDutyModel::where('id', $payduty_id)->first();
        
        if($payDuty){
            $payDuty->change_status_reason = $reason;
            $payDuty->status = $status;
            $payDuty->save();
            
            return response()->json(['status' => 200, 'message' => "Pay Duty status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function changeTransportTicketStatus(Request $request){
        $ticket_id = $request->ticket_id;
        $status = $request->status;
        $reason = isset($request->reason) ? $request->reason : '';

        $ticket = TransportationTicketModel::where('id', $ticket_id)->first();
       
        if($ticket){
            $ticket->change_status_reason = $reason;
            $ticket->status = $status;
            $ticket->save();
            // change status of job related to ticket
            $job = JobModel::where('id', $ticket->job_id)->first();
            if($job){
                $job->status = '1';
                $job->save();
            }
            return response()->json(['status' => 200, 'message' => "Ticket status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function viewTicketPdf(Request $request){
        $id = $request->id;
        $flag = $request->flag;
        
        if($flag == '1'){
            $pdfUrl = $this->makeRiggerTicketPdf($id);
        }else if($flag == '2'){
            $pdfUrl = $this->makeTransporterTicketPdf($id);
        }else if($flag == '3'){
            $pdfUrl = $this->makePayDutyPdf($id);
        }else{
            $pdfUrl = '';
        }
        
        $data['pdf_url'] = '/public'.$pdfUrl;
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }


    public function saveEmailSettings(Request $request){
        
        $validatedData = $request->validate([
            'smtp_host' => 'required|max:50',
            'smtp_port' => 'required|numeric|digits_between:1,5',
            'smtp_username' => 'required|max:50',
            'smtp_password' => 'required',
            'encryption_type' => 'required',
            'from_email' => 'required|email|max:100',
            'from_name' => 'required|max:50',
        ]); 
        
        $EmailSetting = EmailSetting::find('1');

        if(!$EmailSetting){
            $EmailSetting = new EmailSetting();
        }
        
        $EmailSetting->smtp_host = $request->smtp_host;
        $EmailSetting->smtp_port = $request->smtp_port;
        $EmailSetting->smtp_username = $request->smtp_username;
        $EmailSetting->smtp_password = $request->smtp_password;
        $EmailSetting->encryption_type = $request->encryption_type;
        $EmailSetting->from_email = $request->from_email;
        $EmailSetting->from_name = $request->from_name;
        
        if($EmailSetting->id == ''){
            $EmailSetting->created_by = Auth::user()->id;
            $EmailSetting->created_at = date('Y-m-d H:i:s');
        }else{
            $EmailSetting->updated_by= Auth::user()->id;
            $EmailSetting->updated_at= date('Y-m-d H:i:s');
        }
        
        $EmailSetting->save();

        return response()->json(['status' => 200, 'message' => 'Settings Updated Successfully']);
    }
    
    public function saveApiSettings(Request $request){
        
        $validatedData = $request->validate([
            'api_record_limit_days' => [
                'required',
                'regex:/^\d+$/',
                'max:5'
            ],
        ], [
            'api_record_limit_days.regex' => 'The :attribute must contain only numbers.',
            'api_record_limit_days.max' => 'The :attribute must not exceed 5 numbers.'
        ]);
        
        $key = 'API_RECORD_LIMIT';
        $value = $request->api_record_limit_days;

        $path = base_path('.env');

        if (file_exists($path)) {
            $envContent = file_get_contents($path);

            // Check if the key already exists
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update the existing key
                $updatedContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                // Add the new key to the end of the file
                $updatedContent = $envContent . PHP_EOL . "{$key}={$value}";
            }

            // Write the updated content back to the .env file
            file_put_contents($path, $updatedContent);
        }
        
        return response()->json(['status' => 200, 'message' => 'Settings Updated Successfully']);
    }

    public function getServicesPageData(Request $request){

        $data['services_list'] = ArchiveService::get();
        $data['total_services'] = ArchiveService::count();
        $data['total_pending'] = ArchiveService::where('status', '0')->count();
        $data['total_inprocess'] = ArchiveService::where('status', '1')->count();
        $data['total_completed'] = ArchiveService::where('status', '2')->count();
        $data['total_cancelled'] = ArchiveService::where('status', '3')->count();
        
        return response()->json(['status' => 200, 'message' => "",'data' => $data]);
    }


    public function saveArchiveServiceData(Request $request){
        
        $validatedData = $request->validate([
            'service_title' => 'required|string|max:50',
            'service_module' => 'required|string',
            'from_date' => 'required|date|before:today',
            'to_date' => 'required|date|after:from_date',
            'service_description' => 'nullable|string|max:250',
            
        ]); 
        
       
        if($request->service_id == ''){
            $ArchiveService = new ArchiveService();
        }else{
            $ArchiveService = ArchiveService::where('id', $request->service_id)->first();
        }
        
        $ArchiveService->title = $request->service_title;
        $ArchiveService->module = $request->service_module;
        $ArchiveService->from_date = $request->from_date;
        $ArchiveService->to_date = $request->to_date;
        $ArchiveService->description = $request->service_description;
        $ArchiveService->status = '0';
        
        if($request->service_id == ''){
            $ArchiveService->created_by = Auth::user()->id;
            $ArchiveService->created_at = date('Y-m-d H:i:s');
        }else{
            $ArchiveService->updated_by= Auth::user()->id;
            $ArchiveService->updated_at= date('Y-m-d H:i:s');
        }
        
        $ArchiveService->save();

        if($request->service_id == ''){
            return response()->json(['status' => 200, 'message' => 'Service Updated Successfully']);
        }else{
            return response()->json(['status' => 200, 'message' => 'Service Added Successfully']);
        }
    }

    public function getSpecificServiceDetails(Request $request){
        $service_id = $request->service_id;
        
        $service = ArchiveService::where('id', $service_id)->first();
        if($service){
            $data['service_detail'] = $service;
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Service not found..."]);
        }
    }

    public function cancelSpecificService(Request $request){
        $service_id = $request->service_id;
        $service = ArchiveService::where('id', $service_id)->first();
        if($service){
            $service->status = '3';// 0:pending, 1:inprocess, 2:completed, 3:cancelled
            $service->save();

            return response()->json(['status' => 200, 'message' => "Service cancelled successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function deleteSpecificService(Request $request){
        
        $service_id = $request->service_id;

        $service = ArchiveService::where('id', $service_id)->first();

        if($service && $service->status == '2'){

            $service->status = '4';// 0:pending, 1:inprocess, 2:completed, 3:cancelled, 4:deleted
            $service->save();

            if($service->module == 'JOB'){
                $archiveData = ArchiveJob::where('service_id', $service->id)->first();
            }
            if($service->module == 'RIGGER TICKET'){
                $archiveData = ArchiveRiggerTicket::where('service_id', $service->id)->first();
            }
            if($service->module == 'RIGGER TICKET'){
                $archiveData = ArchiveTransportationTicket::where('service_id', $service->id)->first();
            }
            if($service->module == 'RIGGER TICKET'){
                $archiveData = ArchivePayDutyForm::where('service_id', $service->id)->first();
            }

            if($archiveData){
                $archiveData->json_data = '[]';
                $archiveData->save();
            }
            return response()->json(['status' => 200, 'message' => "Service data deleted successfully"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
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
                ['text' => $form->date != null ? date('d-M-Y', strtotime($form->date)) : '', 'x' => 86, 'y' => 87.5],
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