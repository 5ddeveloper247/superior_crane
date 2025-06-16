<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required',
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'exists:users,email',
                function ($attribute, $value, $fail) {
                    $user = DB::table('users')->where('email', $value)->first();
                    if ($user && $user->status == 2) {
                        $fail('The selected email is invalid.');
                    }
                },
            ],
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                
                if($user->status == '0'){
                    return response()->json([
                        'success' => false,
                        'message' => 'User Account is InActive. Please Contact Admin.'
                    ], 401);
                
                }else if($user->status == '2'){
                
                    return response()->json([
                        'success' => false,
                        'message' => 'The selected email is invalid.'
                    ], 401);
                
                }else if($user->role_id == '2' || $user->role_id == '3' || $user->role_id == '4' || $user->role_id == '5'){
                
                    return response()->json([
                        'success' => true,
                        'message' => 'Logged in successfully',
                        'user' => $user
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid Credentials.'
                    ], 401);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ], 401);
            
           
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error logging into the system: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }



    // forget password api

    public function validateemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            ]);

        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $user = User::where('email', $request->email)->first();
            if($user){
                $otp = implode('', array_map(function() {
                    return mt_rand(0, 9);
                }, range(1, 5)));
            
                $user->otp = $otp;
                $user->save();

                $mailData = [];
                $mailData['otp'] = $otp;
                $mailData['username'] = $user->name;
                $body = view('emails.forgot_password', $mailData)->render();
                sendMail($user->name, $user->email, 'Superior Crane', 'Password Reset Request', $body); // send_to_name, send_to_email, email_from_name, subject, body

                return response()->json([
                    'success' => true,
                    'message' => 'Email Validated'
                ], 200);

            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'User with this email does not exist'
                ], 401);
            }
            
        } catch (\Exception $e) {
             // Log the error for debugging purposes
             Log::error('Error validating the email: ' . $e->getMessage());
             return response()->json([
                 'success' => false,
                 'message' => "Oops! Network Error",
             ], 500);
         }
    }

    public function verifyotp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'otp' => 'required|numeric',
            ]);

        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $user = User::where('email', $request->email)->first();
            if($user){

                if($request->otp == $user->otp){
                    return response()->json([
                        'success' => true,
                        'message' => 'Otp Validated'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Otp verification failed'
                    ], 401);
                } 
            }
            else{
             return response()->json([
                 'success' => false,
                 'message' => 'User with this email does not exist'
             ], 401);
            }
            
         } catch (\Exception $e) {
             // Log the error for debugging purposes
             Log::error('Error validating the otp: ' . $e->getMessage());
             return response()->json([
                 'success' => false,
                 'message' => "Oops! Network Error",
             ], 500);
         }
    }

    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
                
            ],
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            $user = User::where('email', $request->email)->first();
            if($user){
                $user->password = bcrypt($request->password);
                $user->otp = null;
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Password Updated Successfully'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User with this email does not exist'
                ], 401);
            }
            
         } catch (\Exception $e) {
             // Log the error for debugging purposes
             Log::error('Error updating the password: ' . $e->getMessage());
             return response()->json([
                 'success' => false,
                 'message' => "Oops! Network Error",
             ], 500);
         }
    }
}
