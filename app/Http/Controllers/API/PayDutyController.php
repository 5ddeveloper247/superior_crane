<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayDutyModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PayDutyController extends Controller
{
    public function add_pay_duty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'location' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i',
            'total_hours' => 'required|string|max:100',
            'officer' => 'required|string|max:100',
            'officer_name' => 'required|string|max:100',
            'division' => 'required|string|max:200',
            'email' => 'required|string|email|max:100',
            'signature' => 'required|string',
            'site_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $form->created_by = $request->created_by;
            $form->save();

            if ($request->hasFile('site_pic')) {
                $path = '/uploads/pay_duty_forms/' . $form->id;
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $form->site_pic = $full_path;
                $form->save();
            }

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
}
