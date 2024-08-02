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
use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;

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
        }else{
            if($request->password != ''){
                $user->password= bcrypt($request->password);
            }
        }
        
        $user->save();

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
            return response()->json(['status' => 200, 'message' => "User status updated successfully."]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }

    public function getSpecificUserDetails(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->where('role_id','!=','0')->with(['role'])->first();
        if($user){
            $data['user_detail'] = $user;
            return response()->json(['status' => 200, 'message' => "", 'data'=> $data]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong..."]);
        }
    }
    
}
