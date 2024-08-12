<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransportationTicketController extends Controller
{
    public function add_transportation_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'job_id' => 'required',
            'pickup_address' => 'required|string',
            'delivery_address' => 'required|string',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'notes' => 'required|string',
            'job_number' => 'required|string|max:50',
            'job_special_instructions' => 'required|string',
            'po_number' => 'required|string|max:50',
            'po_special_instructions' => 'required|string',
            'site_contact_name' => 'required|string|max:100',
            'site_name_special_instructions' => 'required|string',
            'site_contact_number' => 'required|string|max:17',
            'site_number_special_instructions' => 'required|string',
            'shipper_name' => 'required|string|max:100',
            // 'shipper_signature' => 'required|string',
            'shipper_signature_date' => 'required|date',
            'shipper_time_in' => 'required|date_format:H:i',
            'shipper_time_out' => 'required|date_format:H:i',
            'pickup_driver_name' => 'required|string|max:100',
            // 'pickup_driver_signature' => 'required|string',
            'pickup_driver_signature_date' => 'required|date',
            'pickup_driver_time_in' => 'required|date_format:H:i',
            'pickup_driver_time_out' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|string|email|max:100',
            // 'customer_signature' => 'required|string',
            'customer_signature_date' => 'required|date',
            'customer_time_in' => 'required|date_format:H:i',
            'customer_time_out' => 'required|date_format:H:i',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $record = new TransportationTicketModel; 
            $record->user_id = $request->user_id;
            $record->job_id = $request->job_id;
            $record->pickup_address = $request->pickup_address;
            $record->delivery_address = $request->delivery_address;
            $record->time_in = $request->time_in;
            $record->time_out = $request->time_out;
            $record->notes = $request->notes;
            $record->job_number = $request->job_number;
            $record->job_special_instructions = $request->job_special_instructions;
            $record->po_number = $request->po_number;
            $record->po_special_instructions = $request->po_special_instructions;
            $record->site_contact_name = $request->site_contact_name;
            $record->site_contact_name_special_instructions = $request->site_name_special_instructions;
            $record->site_contact_number = $request->site_contact_number;
            $record->site_contact_number_special_instructions = $request->site_number_special_instructions;
            $record->shipper_name = $request->shipper_name;
            // $record->shipper_signature = $request->shipper_signature;
            $record->shipper_signature_date = $request->shipper_signature_date;
            $record->shipper_time_in = $request->shipper_time_in;
            $record->shipper_time_out = $request->shipper_time_out;
            $record->pickup_driver_name = $request->pickup_driver_name;
            // $record->pickup_driver_signature = $request->pickup_driver_signature;
            $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
            $record->pickup_driver_time_in = $request->pickup_driver_time_in;
            $record->pickup_driver_time_out = $request->pickup_driver_time_out;
            $record->customer_name = $request->customer_name;
            $record->customer_email = $request->customer_email;
            // $record->customer_signature = $request->customer_signature;
            $record->customer_signature_date = $request->customer_signature_date;
            $record->customer_time_in = $request->customer_time_in;
            $record->customer_time_out = $request->customer_time_out;
            $record->status = $request->status;
            $record->created_by = $request->created_by;
            $record->save();

            if ($request->hasFile('shipper_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/shipper_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->shipper_signature = $full_path;
                $record->save();
            }

            if ($request->hasFile('pickup_driver_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/pickup_driver_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->pickup_driver_signature = $full_path;
                $record->save();
            }

            if ($request->hasFile('customer_signature')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id . "/customer_signature";
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->customer_signature = $full_path;
                $record->save();
            }

            // $req_file = 'images';
            // $path = '/uploads/transportation_tickets_images/' . $record->id .'/images';

            // if ($request->hasFile($req_file)) {

            //     if (!File::isDirectory(public_path($path))) {
            //         File::makeDirectory(public_path($path), 0777, true);
            //     }
                
            //     $uploadedFiles = $request->file($req_file);

            //     foreach ($uploadedFiles as $file) {
            //         $file_extension = $file->getClientOriginalExtension();
            //         $date_append = Str::random(32);
            //         $file->move(public_path($path), $date_append . '.' . $file_extension);
    
            //         $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

            //         $TransportationTicketImages = new TransportationTicketImages();
            //         $TransportationTicketImages->ticket_id = $record->id;
            //         $TransportationTicketImages->file_name = $file->getClientOriginalName();
            //         $TransportationTicketImages->path = $savedFilePaths;
            //         $TransportationTicketImages->save();
            //     }
            // }

            $images = $request->images;
            if(count($images) > 0){
                
                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = Str::random(32).'.'.'png';
                    $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $record->id;
                    $TransportationTicketImages->path = 'public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Transportation Ticket added successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function update_transportation_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'user_id' => 'required',
            'job_id' => 'required',
            'pickup_address' => 'required|string',
            'delivery_address' => 'required|string',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'notes' => 'required|string',
            'job_number' => 'required|string|max:50',
            'job_special_instructions' => 'required|string',
            'po_number' => 'required|string|max:50',
            'po_special_instructions' => 'required|string',
            'site_contact_name' => 'required|string|max:100',
            'site_name_special_instructions' => 'required|string',
            'site_contact_number' => 'required|string|max:17',
            'site_number_special_instructions' => 'required|string',
            'shipper_name' => 'required|string|max:100',
            // 'shipper_signature' => 'required|string',
            'shipper_signature_date' => 'required|date',
            'shipper_time_in' => 'required|date_format:H:i',
            'shipper_time_out' => 'required|date_format:H:i',
            'pickup_driver_name' => 'required|string|max:100',
            // 'pickup_driver_signature' => 'required|string',
            'pickup_driver_signature_date' => 'required|date',
            'pickup_driver_time_in' => 'required|date_format:H:i',
            'pickup_driver_time_out' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|string|email|max:100',
            // 'customer_signature' => 'required|string',
            'customer_signature_date' => 'required|date',
            'customer_time_in' => 'required|date_format:H:i',
            'customer_time_out' => 'required|date_format:H:i',
            'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
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
            $record = TransportationTicketModel::where('id', $request->ticket_id)->first();
            if($record){
                $record->user_id = $request->user_id;
                $record->job_id = $request->job_id;
                $record->pickup_address = $request->pickup_address;
                $record->delivery_address = $request->delivery_address;
                $record->time_in = $request->time_in;
                $record->time_out = $request->time_out;
                $record->notes = $request->notes;
                $record->job_number = $request->job_number;
                $record->job_special_instructions = $request->job_special_instructions;
                $record->po_number = $request->po_number;
                $record->po_special_instructions = $request->po_special_instructions;
                $record->site_contact_name = $request->site_contact_name;
                $record->site_contact_name_special_instructions = $request->site_name_special_instructions;
                $record->site_contact_number = $request->site_contact_number;
                $record->site_contact_number_special_instructions = $request->site_number_special_instructions;
                $record->shipper_name = $request->shipper_name;
                // $record->shipper_signature = $request->shipper_signature;
                $record->shipper_signature_date = $request->shipper_signature_date;
                $record->shipper_time_in = $request->shipper_time_in;
                $record->shipper_time_out = $request->shipper_time_out;
                $record->pickup_driver_name = $request->pickup_driver_name;
                // $record->pickup_driver_signature = $request->pickup_driver_signature;
                $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
                $record->pickup_driver_time_in = $request->pickup_driver_time_in;
                $record->pickup_driver_time_out = $request->pickup_driver_time_out;
                $record->customer_name = $request->customer_name;
                $record->customer_email = $request->customer_email;
                // $record->customer_signature = $request->customer_signature;
                $record->customer_signature_date = $request->customer_signature_date;
                $record->customer_time_in = $request->customer_time_in;
                $record->customer_time_out = $request->customer_time_out;
                $record->status = $request->status;
                $record->created_by = $request->created_by;
                $record->save();

                if ($request->hasFile('shipper_signature')) {

                    $del_path = str_replace(url('/public/'), '', $record->shipper_signature);
                    deleteImage($del_path);

                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/shipper_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->shipper_signature = $full_path;
                    $record->save();
                }

                if ($request->hasFile('pickup_driver_signature')) {
                    
                    $del_path = str_replace(url('/public/'), '', $record->pickup_driver_signature);
                    deleteImage($del_path);
                    
                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/pickup_driver_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->pickup_driver_signature = $full_path;
                    $record->save();
                }

                if ($request->hasFile('customer_signature')) {

                    $del_path = str_replace(url('/public/'), '', $record->customer_signature);
                    deleteImage($del_path);

                    $path = '/uploads/transportation_tickets_images/' . $record->id . "/customer_signature";
                    $uploadedFile = $request->file('site_pic');
                    $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                    $full_path = url('/public/') . $savedFile;
                    $record->customer_signature = $full_path;
                    $record->save();
                }

            //     $req_file = 'images';
            //     $path = '/uploads/transportation_tickets_images/' . $record->id .'/images';

            //     if ($request->hasFile($req_file)) {

            //         $previous_images = TransportationTicketImages::where('ticket_id', $record->id)->get();
            //         if(count($previous_images) > 0){
            //             foreach($previous_images as $img){
            //                 $del_path = str_replace(url('/public/'), '', $img->path);
            //                 deleteImage($del_path);
            //                 TransportationTicketImages::where('id', $img->id)->delete();
            //             }
            //         }

            //         if (!File::isDirectory(public_path($path))) {
            //             File::makeDirectory(public_path($path), 0777, true);
            //         }
                    
            //         $uploadedFiles = $request->file($req_file);

            //         foreach ($uploadedFiles as $file) {
            //             $file_extension = $file->getClientOriginalExtension();
            //             $date_append = Str::random(32);
            //             $file->move(public_path($path), $date_append . '.' . $file_extension);
        
            //             $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

            //             $TransportationTicketImages = new TransportationTicketImages();
            //             $TransportationTicketImages->ticket_id = $record->id;
            //             $TransportationTicketImages->file_name = $file->getClientOriginalName();
            //             $TransportationTicketImages->path = $savedFilePaths;
            //             $TransportationTicketImages->save();
            //         }
            //     }
            // } 

                $images = $request->images;
                if(count($images) > 0){
                    
                    $previous_images = TransportationTicketImages::where('ticket_id', $record->id)->get();
                    if(count($previous_images) > 0){
                        foreach($previous_images as $img){
                            $del_path = str_replace(url('/public/'), '', $img->path);
                            deleteImage($del_path);
                            TransportationTicketImages::where('id', $img->id)->delete();
                        }
                    }

                    foreach ($images as $index => $imageData) {
                        $image = $imageData['file'];
                        $title = $imageData['title'];
                
                        // Decode base64 string
                        $image = str_replace('data:image/png;base64,', '', $image);
                        $image = str_replace(' ', '+', $image);
                        $imageName = Str::random(32).'.'.'png';
                        $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
                
                        if (!file_exists($filePath)) {
                            mkdir($filePath, 0777, true);
                        }
                
                        \File::put($filePath . '/' . $imageName, base64_decode($image));
                
                        // Save image path and title to database
                        $TransportationTicketImages = new TransportationTicketImages();
                        $TransportationTicketImages->ticket_id = $record->id;
                        $TransportationTicketImages->path = 'public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                        $TransportationTicketImages->file_name = $title;
                        $TransportationTicketImages->save();
                    }
                }
            }
            

            return response()->json([
                'success' => true,
                'message' => 'Transportation Ticket updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error adding record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getTicketList(Request $request)
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

            $transportation_ticket_list = TransportationTicketModel::where('user_id', $request->user_id)->with(['ticketImages'])->get();
            
            if($transportation_ticket_list) {
                return response()->json([
                    'success' => true,
                    'ticket_list' => $transportation_ticket_list,
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

    public function getTicketDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $ticket_detail = TransportationTicketModel::where('id', $request->ticket_id)->with(['ticketImages'])->first();
            if($ticket_detail) {
                return response()->json([
                    'success' => true,
                    'ticket_detail' => $ticket_detail,
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
