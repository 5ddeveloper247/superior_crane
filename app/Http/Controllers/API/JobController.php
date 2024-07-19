<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function add_job(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:50',
            'job_time' => 'required|date_format:H:i',
            'date' => 'required|date',
            'address' => 'required|string|max:200',
            'equipment_to_be_used' => 'required|string|max:255',
            'rigger_assigned' => 'required|numeric',
            'supplier_name' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'job_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scci' => 'boolean',
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
            $job->client_name = $request->client_name;
            $job->job_time = $request->job_time;
            $job->date = $request->date;
            $job->address = $request->address;
            $job->equipment_to_be_used = $request->equipment_to_be_used;
            $job->rigger_assigned = $request->rigger_assigned;
            $job->supplier_name = $request->supplier_name;
            $job->notes = $request->notes;
            $job->scci = $request->scci ?? false;
            $job->created_by = $request->created_by;
            $job->save();
    

            if ($request->hasFile('job_image')) {

                $path = '/uploads/job_images/' . $job->id;
                $uploadedFile = $request->file('job_image');
                $savedFile = saveSingleImage($uploadedFile, $path);
                $full_path = url('/public/') . $savedFile;
                $job->job_image = $full_path;
                $job->save();
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


    public function filtered_jobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'month' => 'required|numeric',
            'day' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
        
            
            $date = $request->year . '-' . sprintf('%02d', $request->month) . '-' . sprintf('%02d', $request->day);
            $jobs = JobModel::where('date', $date)->get();
            if(count($jobs) > 0) {
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

            $job = JobModel::where('id', $request->job_id)->first();
            if($job) {
            return response()->json([
                'success' => true,
                'job_detail' => $job,
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


    public function updatejob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric',
            'client_name' => 'required|string|max:50',
            'job_time' => 'required|date_format:H:i',
            'date' => 'required|date',
            'address' => 'required|string|max:200',
            'equipment_to_be_used' => 'required|string|max:255',
            'rigger_assigned' => 'required|numeric',
            'supplier_name' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'job_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scci' => 'boolean',
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
            $job->client_name = $request->client_name;
            $job->job_time = $request->job_time;
            $job->date = $request->date;
            $job->address = $request->address;
            $job->equipment_to_be_used = $request->equipment_to_be_used;
            $job->rigger_assigned = $request->rigger_assigned;
            $job->supplier_name = $request->supplier_name;
            $job->notes = $request->notes;
            $job->scci = $request->scci ?? false;
            $job->created_by = $request->created_by;
            $job->save();
    

            if ($request->hasFile('job_image')) {
                $del_path = str_replace(url('/public/'), '', $job->job_image);
                deleteImage($del_path);
                $path = '/uploads/job_images/' . $job->id;
                $uploadedFile = $request->file('job_image');
                $savedFile = saveSingleImage($uploadedFile, $path);
                $full_path = url('/public/') . $savedFile;
                $job->job_image = $full_path;
                $job->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully'
            ], 200);
            }
            else{
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
}
