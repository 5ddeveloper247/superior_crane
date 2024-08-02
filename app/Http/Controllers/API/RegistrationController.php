<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class RegistrationController extends Controller
{
   public function register(Request $request)
   {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users',
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
            
            $user = new User;
            $user->name = $request->name;
            $user->email= $request->email;
            $user->password= bcrypt($request->password);
            $user->role_id = $request->role;
            $user->save();
            
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

            $users = User::whereIn('role_id', ['3','4','5'])->get();
            
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
}
