<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Roles;

class RegistrationController extends Controller
{
   public function register(Request $request)
   {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                'regex:/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Z]{2,}$/i',
                function ($attribute, $value, $fail) {
                    // Check if email exists with status != 2
                    $existingUser = DB::table('users')->where('email', $value)->where('status', '!=', 2)->first();
                    if ($existingUser) {
                        $fail('The email has already been taken.');
                    }
                },
            ],
            'phone_number' => 'required|numeric|digits_between:7,18',
            'role' => 'required|in:3,4,5', // 3=>Rigger, 4=>Transporter, 5=> Both Rigger & Transporter
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
        ], [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            
            $existingUser = User::where('email', $request->email)->where('status', 2)->first();

            if ($existingUser) {
                // Update the existing user with status = 2
                $existingUser->name = $request->name;
                $existingUser->phone_number = $request->phone_number;
                $existingUser->password = bcrypt($request->password);
                $existingUser->role_id = $request->role;
                $existingUser->status = 1; // Reactivate the user
                $existingUser->save();
                
                $user = $existingUser;
            } else {
                // If no user with status 2 exists, create a new user
                $user = new User;
                $user->name = $request->name;
                $user->email= $request->email;
                $user->phone_number= $request->phone_number;
                $user->password= bcrypt($request->password);
                $user->role_id = $request->role;
                $user->save();
            }
            
            $roleName = Roles::where('id', $request->role)->value('role_name');

            $mailData = [];
            $mailData['user'] = $user->name;
            $mailData['username'] = $user->name;
            $mailData['email'] = $user->email;
            $mailData['phone_num'] = $user->phone_number;
            $mailData['role'] = $roleName;
            $mailData['text1'] = "Welcome to Superior Crane! We're thrilled to have you on board.";
            $mailData['text2'] = "If you have any questions, feel free to reach out to us at support@superiorcrane.com.";

            $body = view('emails.signup_welcome', $mailData);
            $userEmailsSend = $user->email;//'hamza@5dsolutions.ae';//
            sendMail($user->name, $userEmailsSend, 'Superior Crane', 'Register User', $body);

            $mailData['user'] = 'Admin';
            $mailData['text1'] = "A new user has just signed up on Superior Crane.";
            $mailData['text2'] = "Please review their details in the admin panel.";
            $userEmailsSend1 = env('MAIL_ADMIN');
            $body = view('emails.signup_welcome', $mailData);
            sendMail($user->name, $userEmailsSend1, 'Superior Crane', 'Register User', $body);
            
            return response()->json([
                'success' => true,
                'message' => 'Signup successfull'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing user info: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getAllUsersList(Request $request)
    {
        try {

            $users = User::whereIn('role_id', ['2','3','4','5'])->where('status', '1')->get();
            
            if($users) {
                return response()->json([
                    'success' => true,
                    'users_list' => $users,
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

    public function delete_user(Request $request)
   {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = DB::table('users')->where('id', $value)->first();
                    if ($user && in_array($user->role_id, [0, 1])) {
                        $fail('The selected user id is invalid.');
                    }
                },
            ],
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            
            // $user = User::where('id', $request->user_id)->delete();
            $user = User::where('id', $request->user_id)->first();
            $user->status = '2'; //0:InActive, 1:Active, 2:Deleted
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully...'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing user info: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }
}
