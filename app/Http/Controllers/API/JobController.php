<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobModel;
use App\Models\JobImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function add_job(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_type' => 'required|string|max:50',
            'job_time' => 'required|date_format:H:i',
            'client_name' => 'required|string|max:50',
            'equipment_to_be_used' => 'required|string|max:255',
            'client_name' => 'required|string|max:50',
            'rigger_assigned' => 'required|numeric',
            'date' => 'required|date',
            'address' => 'required|string|max:200',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s',
            'supplier_name' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'scci' => 'boolean',
            'job_image' => 'required',
            'job_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required',
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
            $job->scci = $request->scci ?? false;
            $job->status = $request->status;
            $job->created_by = $request->created_by;
            
            $job->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Job added successfully'
            ], 200);
            $req_file = 'job_image';
            $path = '/uploads/job_images/' . $job->id;

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

                    $JobImages = new JobImages();
                    $JobImages->landlord_id = $job->id;
                    $JobImages->file_name = $file->getClientOriginalName();
                    $JobImages->path = $savedFilePaths;
                    $JobImages->save();
                }
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

    public function updatejob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'job_type' => 'required|string|max:50',
            'job_time' => 'required|date_format:H:i',
            'client_name' => 'required|string|max:50',
            'equipment_to_be_used' => 'required|string|max:255',
            'client_name' => 'required|string|max:50',
            'rigger_assigned' => 'required|numeric',
            'date' => 'required|date',
            'address' => 'required|string|max:200',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s',
            'supplier_name' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'scci' => 'boolean',
            'job_image' => 'required',
            'job_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required',
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
                $job->scci = $request->scci ?? false;
                $job->status = $request->status;
                $job->created_by = $request->created_by;
                $job->save();
    

                $req_file = 'job_image';
                $path = '/uploads/job_images/' . $job->id;

                if ($request->hasFile($req_file)) {
                    
                    $previous_images = JobImages::where('job_id', $job->id)->get();
                    if(count($previous_images) > 0){
                        foreach($previous_images as $img){
                            $del_path = str_replace(url('/public/'), '', $img->path);
                            deleteImage($del_path);
                            JobImages::where('id', $img->id)->delete();
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

                        $JobImages = new JobImages();
                        $JobImages->landlord_id = $job->id;
                        $JobImages->file_name = $file->getClientOriginalName();
                        $JobImages->path = $savedFilePaths;
                        $JobImages->save();
                    }
                }
               
                return response()->json([
                    'success' => true,
                    'message' => 'Job updated successfully'
                ], 200);
            
            }else{

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



    public function filter_jobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
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
            $jobs = JobModel::where('date', $date)->with(['jobImages'])->get();
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

    public function advance_filter_jobs(Request $request)
    {
        $job_type = isset($request->job_type) ? $request->job_type : '';
        $job_category = isset($request->job_category) ? $request->job_category : '';
        $client_name = isset($request->client_name) ? $request->client_name : '';
        $address = isset($request->address) ? $request->address : '';
        $start_date = isset($request->start_date) ? $request->start_date : '';
        $end_date = isset($request->end_date) ? $request->end_date : '';
        $assigned_rigger_transporter = isset($request->assigned_rigger_transporter) ? $request->assigned_rigger_transporter : '';
        $supplier_name = isset($request->supplier_name) ? $request->supplier_name : '';
        $status = isset($request->status) ? $request->status : '';

        // Check if validation fails
        if($job_type=='' && $job_category=='' && $client_name=='' && $address=='' && 
            $start_date=='' && $end_date=='' && $assigned_rigger_transporter=='' && 
            $supplier_name=='' && $status==''){
                return response()->json([
                    'success' => false,
                    'errors' => 'Choose atleast one filter!',
                ], 422);
        }

        try {
            
            // make query for get listing
            $query = JobModel::with(['jobImages']);
            
            if ($job_type!='') {
                $query->where('job_type', $job_type);
            }

            if ($job_category!='') {
                $query->where('scci', $job_category);
            }

            if ($client_name!='') {
                $query->where('client_name', 'like', '%' . $client_name . '%');
            }

            if ($address!='') {
                $query->where('address', 'like', '%' . $address . '%');
            }

            if ($assigned_rigger_transporter!='') {
                $query->where('rigger_assigned', $assigned_rigger_transporter);
            }

            if ($supplier_name!='') {
                $query->where('supplier_name', $supplier_name);
            }

            if ($status!='') {
                $query->where('status', $status);
            }

            if ($start_date!='' && $end_date=='' ) {

                $query->whereDate('date', '>=', $start_date);
            
            }else if ($end_date!='' && $start_date=='' ) {
            
                $query->whereDate('date', '<=', $end_date);
            
            }else if ($start_date!='' && $end_date!='' ) {
            
                $query->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
            
            }

            $jobs = $query->get();
            
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

            $job = JobModel::where('id', $request->job_id)->with(['jobImages'])->first();
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

    
}