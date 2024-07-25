<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransportationTicketModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class TransportationTicketController extends Controller
{
    public function add_transportation_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'site_contact_name_special_instructions' => 'required|string',
            'site_contact_number' => 'required|string|max:17',
            'site_contact_number_special_instructions' => 'required|string',
            'shipper_name' => 'required|string|max:100',
            'shipper_signature' => 'required|string',
            'shipper_signature_date' => 'required|date',
            'shipper_time_in' => 'required|date_format:H:i',
            'shipper_time_out' => 'required|date_format:H:i',
            'pickup_driver_name' => 'required|string|max:100',
            'pickup_driver_signature' => 'required|string',
            'pickup_driver_signature_date' => 'required|date',
            'pickup_driver_time_in' => 'required|date_format:H:i',
            'pickup_driver_time_out' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|string|email|max:100',
            'customer_signature' => 'required|string',
            'customer_signature_date' => 'required|date',
            'customer_time_in' => 'required|date_format:H:i',
            'customer_time_out' => 'required|date_format:H:i',
            'signed_status' => 'required|integer',   // 0 for unsigned(draft) and 1 for signed
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
            $record = new TransportationTicketModel; 
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
            $record->site_contact_name_special_instructions = $request->site_contact_name_special_instructions;
            $record->site_contact_number = $request->site_contact_number;
            $record->site_contact_number_special_instructions = $request->site_contact_number_special_instructions;
            $record->shipper_name = $request->shipper_name;
            $record->shipper_signature = $request->shipper_signature;
            $record->shipper_signature_date = $request->shipper_signature_date;
            $record->shipper_time_in = $request->shipper_time_in;
            $record->shipper_time_out = $request->shipper_time_out;
            $record->pickup_driver_name = $request->pickup_driver_name;
            $record->pickup_driver_signature = $request->pickup_driver_signature;
            $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
            $record->pickup_driver_time_in = $request->pickup_driver_time_in;
            $record->pickup_driver_time_out = $request->pickup_driver_time_out;
            $record->customer_name = $request->customer_name;
            $record->customer_email = $request->customer_email;
            $record->customer_signature = $request->customer_signature;
            $record->customer_signature_date = $request->customer_signature_date;
            $record->customer_time_in = $request->customer_time_in;
            $record->customer_time_out = $request->customer_time_out;
            $record->signed_status = $request->signed_status;
            $record->created_by = $request->created_by;
            $record->save();

            if ($request->hasFile('site_pic')) {
                $path = '/uploads/transportation_tickets_images/' . $record->id;
                $uploadedFile = $request->file('site_pic');
                $savedFile = $this->saveSingleImage($uploadedFile, $path); 
                $full_path = url('/public/') . $savedFile;
                $record->site_pic = $full_path;
                $record->save();
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
}
