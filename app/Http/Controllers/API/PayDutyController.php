<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayDutyModel;
use App\Models\PayDutytImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PayDutyController extends Controller
{
    public function add_pay_duty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            $req_file = 'images';
            $path = '/uploads/pay_duty_images/' . $form->id .'/images';

            if ($request->hasFile($req_file)) {

                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true);
                }
                
                $uploadedFiles = $request->file($req_file);

                foreach ($uploadedFiles as $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $date_append = Str::random(32);
                    $file->move(public_path($path), $date_append . '.' . $file_extension);
    
                    $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

                    $PayDutytImages = new PayDutytImages();
                    $PayDutytImages->ticket_id = $form->id;
                    $PayDutytImages->file_name = $file->getClientOriginalName();
                    $PayDutytImages->path = $savedFilePaths;
                    $PayDutytImages->save();
                }
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

    public function update_pay_duty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_duty_id' => 'required',
            'user_id' => 'required',
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

                $req_file = 'images';
                $path = '/uploads/pay_duty_images/' . $form->id .'/images';

                if ($request->hasFile($req_file)) {

                    $previous_images = PayDutytImages::where('pay_duty_id', $form->id)->get();
                    if(count($previous_images) > 0){
                        foreach($previous_images as $img){
                            $del_path = str_replace(url('/public/'), '', $img->path);
                            deleteImage($del_path);
                            PayDutytImages::where('id', $img->id)->delete();
                        }
                    }

                    if (!File::isDirectory(public_path($path))) {
                        File::makeDirectory(public_path($path), 0777, true);
                    }
                    
                    $uploadedFiles = $request->file($req_file);

                    foreach ($uploadedFiles as $file) {
                        $file_extension = $file->getClientOriginalExtension();
                        $date_append = Str::random(32);
                        $file->move(public_path($path), $date_append . '.' . $file_extension);
        
                        $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

                        $PayDutytImages = new PayDutytImages();
                        $PayDutytImages->ticket_id = $form->id;
                        $PayDutytImages->file_name = $file->getClientOriginalName();
                        $PayDutytImages->path = $savedFilePaths;
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
}
