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

class ForgetPasswordController extends Controller
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

    
    public function forget_password(Request $request)
    {
        $data['pageTitle'] = 'Forget Password';
        $data['step'] = '1';
        return view('admin/forget_password')->with($data);
    }

    public function forgetPassword_step1(Request $request)
    {
        session()->forget('error');
        $data['pageTitle'] = 'Forget Password';

        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->whereIn('role_id', ['0','1'])->first();
        
        if($user){
            
            // generate OTP
            $otp = implode('', array_map(function() {
                return mt_rand(0, 9);
            }, range(1, 5)));
        
            $user->otp = $otp;
            $user->save();

            $mailData = [];
            $mailData['otp'] = $otp;
            $mailData['username'] = $user->name;
            $body = view('emails.forgot_password', $mailData);
            sendMail($user->name, $user->email, 'Superior Crane', 'Password Reset Request', $body); // send_to_name, send_to_email, email_from_name, subject, body

            $data['step'] = '2';
            $data['email'] = $request->email;
            return view('admin/forget_password')->with($data);
        
        }else{
            $request->session()->flash('error', 'The selected email is invalid.');
            return redirect()->route('forget_password', ['step' => 1, 'email' => $request->email]);
        }
    }

    public function forgetPassword_step2(Request $request)
    {   
        session()->forget('error');
        $data['pageTitle'] = 'Forget Password';
        
        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4.$request->otp5;

        if($otp != ''){
            $user = User::where('email', $request->email)->whereIn('role_id', ['0','1'])->first();
        
            if($user){
                
                if($otp == $user->otp){
                    
                    
                    $data['step'] = '3';
                    $data['email'] = $request->email;
                    return view('admin/forget_password')->with($data);

                }else{
                
                    $data['step'] = '2';
                    $data['email'] = $request->email;
                    $request->session()->flash('error', 'OTP is not valid.');
                    return view('admin/forget_password')->with($data);
                }
            }else{
                $request->session()->flash('error', 'Something went wrong.');
                return redirect()->route('forget_password', ['step' => 1, 'email' => $request->email]);
            }
        }else{

            $data['step'] = '2';
            $data['email'] = $request->email;
            $request->session()->flash('error', 'OTP is required.');
            return view('admin/forget_password')->with($data);

        }
    }

    public function forgetPassword_step3(Request $request)
    {   
        session()->forget('error');
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';
        $data['pageTitle'] = 'Forget Password';
        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $password = $request->password;
        $confirm_password = $request->password_confirmation;
        
        $data['password'] = $request->password;
        $data['password_confirmation'] = $request->password_confirmation;
        
        if($password == ''){
            $data['step'] = '3';
            $data['email'] = $request->email;
            $request->session()->flash('error', 'password is required.');
            return view('admin/forget_password')->with($data);
        }
        if(strlen($password) < 8){
            $data['step'] = '3';
            $data['email'] = $request->email;
            $request->session()->flash('error', 'password must be minimum 8 characters.');
            return view('admin/forget_password')->with($data);
        }
        if (!preg_match($pattern, $password)) {
            $data['step'] = '3';
            $data['email'] = $request->email;
            $request->session()->flash('error', 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
            return view('admin/forget_password')->with($data);
        }
        if($password != $confirm_password){
            $data['step'] = '3';
            $data['email'] = $request->email;
            $request->session()->flash('error', 'Confirm password must match with password.');
            return view('admin/forget_password')->with($data);
        }
        
        $user = User::where('email', $request->email)->whereIn('role_id', ['0','1'])->first();
    
        if($user){
            
                $user->password = bcrypt($request->password);
                $user->otp = null;
                $user->save();
                
                $request->session()->flash('success', 'Password updated successfully, now login with your new password, Thanks.');
                return redirect('forget_password');
        }else{
            $request->session()->flash('error', 'Something went wrong.');
            return redirect()->route('forget_password', ['step' => 1, 'email' => $request->email]);
        }
        
    }

    public function dashboard(Request $request)
    {
        $data['pageTitle'] = 'Dashboard';
        return view('admin/dashboard')->with($data);
    }
    

    
}
