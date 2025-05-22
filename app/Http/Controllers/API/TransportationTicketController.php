<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobModel;
use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;
use App\Models\TransportationTicketShipper;
use App\Models\TransportationTicketCustomer;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class TransportationTicketController extends Controller
{
    public function add_transportation_ticket(Request $request)
    {
        $request->merge([
            'time_in' => $request->input('time_in') != null ? date('H:i', strtotime($request->input('time_in'))) : null,
            'time_out' => $request->input('time_out') != null ? date('H:i', strtotime($request->input('time_out'))) : null,
            'pickup_driver_time_in' => $request->input('pickup_driver_time_in') != null ? date('H:i', strtotime($request->input('pickup_driver_time_in'))) : null,
            'pickup_driver_time_out' => $request->input('pickup_driver_time_out') != null ? date('H:i', strtotime($request->input('pickup_driver_time_out'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'pickup_address' => 'required|string',
                'delivery_address' => 'required|string',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'required|date_format:H:i',
                'notes' => 'nullable|string',
                'job_number' => 'nullable|string|max:50',
                'job_special_instructions' => 'nullable|string',
                'po_number' => 'nullable|string|max:50',
                'po_special_instructions' => 'nullable|string',
                'site_contact_name' => 'nullable|string|max:100',
                'site_name_special_instructions' => 'nullable|string',
                'site_contact_number' => 'nullable|string|max:17',
                'site_number_special_instructions' => 'nullable|string',
                
                'pickup_driver_name' => 'nullable|string|max:100',
                'pickup_driver_signature' => 'nullable|string',
                'pickup_driver_signature_date' => 'nullable|date',
                'pickup_driver_time_in' => 'nullable|date_format:H:i',
                'pickup_driver_time_out' => 'nullable|date_format:H:i',
                
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                // 'images' => 'required',
                'images.*.file' => 'string',
                'images.*.title' => 'string|max:255',
                'images.*.type' => 'string|max:255',
                
                // Shippers array (optional, but if present, all fields are required)
                'shippers' => 'nullable|array',
                'shippers.*.id' => 'nullable|integer', 
                'shippers.*.shipper_name' => 'required_with:shippers|required|string|max:100',
                'shippers.*.shipper_signature' => 'required_with:shippers|required|string',
                'shippers.*.shipper_signature_date' => 'required_with:shippers|required|date',
                'shippers.*.shipper_time_in' => 'required_with:shippers|required|date_format:H:i',
                'shippers.*.shipper_time_out' => 'required_with:shippers|required|date_format:H:i',
                
                // Consignees validation (array optional, fields required if present)
                'customers' => 'nullable|array',
                'customers.*.id' => 'nullable|integer',
                'customers.*.customer_name' => 'required_with:customers|required|string|max:100',
                'customers.*.customer_email' => 'required_with:customers|required|string|email|max:100',
                'customers.*.customer_signature' => 'required_with:customers|required|string',
                'customers.*.customer_signature_date' => 'required_with:customers|required|date',
                'customers.*.customer_time_in' => 'required_with:customers|required|date_format:H:i',
                'customers.*.customer_time_out' => 'required_with:customers|required|date_format:H:i',
                
                'created_by' => 'required|integer',
            ]);
            
        }else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'job_id' => 'required',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                'created_by' => 'required|integer',
            ]);
        }
        

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
            
            $record->pickup_driver_name = $request->pickup_driver_name;
            $record->pickup_driver_signature = $request->pickup_driver_signature;
            $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
            $record->pickup_driver_time_in = $request->pickup_driver_time_in;
            $record->pickup_driver_time_out = $request->pickup_driver_time_out;
            
            $record->status = $request->status;
            $record->created_by = $request->created_by;
            $record->save();

            if($request->status == '3'){
                JobModel::where('id', $record->job_id)->update(['status' => '3']);
            }

            $shippers = $request->shippers;
            
            if(is_countable($shippers) && count($shippers) > 0){
                foreach ($shippers as $index => $shipperData) {
                    
                    if($shipperData['id'] != null && $shipperData['id'] != ''){
                        $shipper = TransportationTicketShipper::where('id', $shipperData['id'])->first();
                    }else{
                        $shipper = new TransportationTicketShipper();
                    }
                    
                    $shipper->ticket_id = $record->id;
                    $shipper->shipper_name = $shipperData['shipper_name'] ?? '';
                    $shipper->shipper_signature = $shipperData['shipper_signature'] ?? '';
                    $shipper->shipper_signature_date = $shipperData['shipper_signature_date'] ?? '';
                    $shipper->shipper_time_in = date('H:i', strtotime($shipperData['shipper_time_in'])) ?? null;
                    $shipper->shipper_time_out = date('H:i', strtotime($shipperData['shipper_time_out'])) ?? null;
                    $shipper->save();
                }
            }

            $customers = $request->customers;
            if(is_countable($customers) && count($customers) > 0){
                foreach ($customers as $index => $customerData) {

                    if($customerData['id'] != null && $customerData['id'] != ''){
                        $customer = TransportationTicketCustomer::where('id', $shipperData['id'])->first();
                    }else{
                        $customer = new TransportationTicketCustomer();
                    }

                    $customer->ticket_id = $record->id;
                    $customer->customer_name = $customerData['customer_name'] ?? '';
                    $customer->customer_email = $customerData['customer_email'] ?? '';
                    $customer->customer_signature = $customerData['customer_signature'] ?? '';
                    $customer->customer_signature_date = $customerData['customer_signature_date'] ?? '';
                    $customer->customer_time_in = date('H:i', strtotime($customerData['customer_time_in'])) ?? null;
                    $customer->customer_time_out = date('H:i', strtotime($customerData['customer_time_out'])) ?? null;
                    $customer->save();
                }
            }

            $images = $request->images;
            if(is_countable($images) && count($images) > 0){
                
                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
                    $type = $imageData['type'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/jpg;base64,', '', $image);
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace('data:image/pdf;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    
                    if($type == 'image'){
                        $imageName = Str::random(32).'.'.'png';
                    }else{
                        $imageName = Str::random(32).'.'.'pdf';
                    }

                    $filePath = public_path('uploads/transportation_tickets_images/' . $record->id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $record->id;
                    $TransportationTicketImages->path = '/public/uploads/transportation_tickets_images/' . $record->id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->type = $type == 'image' ? 'png' : 'pdf';
                    $TransportationTicketImages->save();
                }
            }

            $this->sendEmailTransporterTicket($record->id);

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
        $request->merge([
            'time_in' => $request->input('time_in') != null ? date('H:i', strtotime($request->input('time_in'))) : null,
            'time_out' => $request->input('time_out') != null ? date('H:i', strtotime($request->input('time_out'))) : null,
            'pickup_driver_time_in' => $request->input('pickup_driver_time_in') != null ? date('H:i', strtotime($request->input('pickup_driver_time_in'))) : null,
            'pickup_driver_time_out' => $request->input('pickup_driver_time_out') != null ? date('H:i', strtotime($request->input('pickup_driver_time_out'))) : null,
        ]);
        if(isset($request->status) && $request->status == '3'){
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'user_id' => 'required',
                'job_id' => 'required',
                'pickup_address' => 'required|string',
                'delivery_address' => 'required|string',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'required|date_format:H:i',
                'notes' => 'nullable|string',
                'job_number' => 'nullable|string|max:50',
                'job_special_instructions' => 'nullable|string',
                'po_number' => 'nullable|string|max:50',
                'po_special_instructions' => 'nullable|string',
                'site_contact_name' => 'nullable|string|max:100',
                'site_name_special_instructions' => 'nullable|string',
                'site_contact_number' => 'nullable|string|max:17',
                'site_number_special_instructions' => 'nullable|string',
                'pickup_driver_name' => 'nullable|string|max:100',
                'pickup_driver_signature' => 'nullable|string',
                'pickup_driver_signature_date' => 'nullable|date',
                'pickup_driver_time_in' => 'nullable|date_format:H:i',
                'pickup_driver_time_out' => 'nullable|date_format:H:i',
                
                // Shippers array (optional, but if present, all fields are required)
                'shippers' => 'nullable|array',
                'shippers.*.id' => 'nullable|integer', 
                'shippers.*.shipper_name' => 'required_with:shippers|required|string|max:100',
                'shippers.*.shipper_signature' => 'required_with:shippers|required|string',
                'shippers.*.shipper_signature_date' => 'required_with:shippers|required|date',
                'shippers.*.shipper_time_in' => 'required_with:shippers|required|date_format:H:i',
                'shippers.*.shipper_time_out' => 'required_with:shippers|required|date_format:H:i',
                
                // Consignees validation (array optional, fields required if present)
                'customers' => 'nullable|array',
                'customers.*.id' => 'nullable|integer',
                'customers.*.customer_name' => 'required_with:customers|required|string|max:100',
                'customers.*.customer_email' => 'required_with:customers|required|string|email|max:100',
                'customers.*.customer_signature' => 'required_with:customers|required|string',
                'customers.*.customer_signature_date' => 'required_with:customers|required|date',
                'customers.*.customer_time_in' => 'required_with:customers|required|date_format:H:i',
                'customers.*.customer_time_out' => 'required_with:customers|required|date_format:H:i',

                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                'created_by' => 'required|integer',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'user_id' => 'required',
                'job_id' => 'required',
                'status' => 'required|integer',   // 1=>draft, 2=>issued, 3=>complete
                'created_by' => 'required|integer',
            ]);
        }

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $record = TransportationTicketModel::where('id', $request->id)->first();
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
                
                $record->pickup_driver_name = $request->pickup_driver_name;
                $record->pickup_driver_signature = $request->pickup_driver_signature;
                $record->pickup_driver_signature_date = $request->pickup_driver_signature_date;
                $record->pickup_driver_time_in = $request->pickup_driver_time_in;
                $record->pickup_driver_time_out = $request->pickup_driver_time_out;
                
                $record->status = $request->status;
                $record->created_by = $request->created_by;
                $record->save();

                if($request->status == '3'){
                    JobModel::where('id', $record->job_id)->update(['status' => '3']);
                }

                $shippers = $request->shippers;
            
            if(is_countable($shippers) && count($shippers) > 0){
                foreach ($shippers as $index => $shipperData) {
                    
                    if($shipperData['id'] != null && $shipperData['id'] != ''){
                        $shipper = TransportationTicketShipper::where('id', $shipperData['id'])->first();
                    }else{
                        $shipper = new TransportationTicketShipper();
                    }
                    
                    $shipper->ticket_id = $record->id;
                    $shipper->shipper_name = $shipperData['shipper_name'] ?? '';
                    $shipper->shipper_signature = $shipperData['shipper_signature'] ?? '';
                    $shipper->shipper_signature_date = $shipperData['shipper_signature_date'] ?? '';
                    $shipper->shipper_time_in = date('H:i', strtotime($shipperData['shipper_time_in'])) ?? null;
                    $shipper->shipper_time_out = date('H:i', strtotime($shipperData['shipper_time_out'])) ?? null;
                    $shipper->save();
                }
            }

            $customers = $request->customers;
            if(is_countable($customers) && count($customers) > 0){
                foreach ($customers as $index => $customerData) {

                    if($customerData['id'] != null && $customerData['id'] != ''){
                        $customer = TransportationTicketCustomer::where('id', $customerData['id'])->first();
                    }else{
                        $customer = new TransportationTicketCustomer();
                    }

                    $customer->ticket_id = $record->id;
                    $customer->customer_name = $customerData['customer_name'] ?? '';
                    $customer->customer_email = $customerData['customer_email'] ?? '';
                    $customer->customer_signature = $customerData['customer_signature'] ?? '';
                    $customer->customer_signature_date = $customerData['customer_signature_date'] ?? '';
                    $customer->customer_time_in = date('H:i', strtotime($customerData['customer_time_in'])) ?? null;
                    $customer->customer_time_out = date('H:i', strtotime($customerData['customer_time_out'])) ?? null;
                    $customer->save();
                }
            }
                
                $this->sendEmailTransporterTicket($record->id);
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

    public function addTicketImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'images' => 'required',
            'images.*.file' => 'required|string',
            'images.*.title' => 'required|string|max:255',
            'images.*.type' => 'required|string|max:255',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $images = $request->images;
            if(is_countable($images) && count($images) > 0){
                
                foreach ($images as $index => $imageData) {
                    $image = $imageData['file'];
                    $title = $imageData['title'];
                    $type = $imageData['type'];
            
                    // Decode base64 string
                    $image = str_replace('data:image/jpg;base64,', '', $image);
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace('data:image/pdf;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);

                    if($type == 'image'){
                        $imageName = Str::random(32).'.'.'png';
                    }else{
                        $imageName = Str::random(32).'.'.'pdf';
                    }
                    
                    $filePath = public_path('uploads/transportation_tickets_images/' . $request->ticket_id);
            
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
            
                    \File::put($filePath . '/' . $imageName, base64_decode($image));
            
                    // Save image path and title to database
                    $TransportationTicketImages = new TransportationTicketImages();
                    $TransportationTicketImages->ticket_id = $request->ticket_id;
                    $TransportationTicketImages->path = '/public/uploads/transportation_tickets_images/' . $request->ticket_id . '/' . $imageName;
                    $TransportationTicketImages->file_name = $title;
                    $TransportationTicketImages->type = $type == 'image' ? 'png' : 'pdf';
                    $TransportationTicketImages->save();
                }
            }

            $ticket_images = TransportationTicketImages::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'ticket_images' => $ticket_images,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function deleteTicketImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            TransportationTicketImages::where('ticket_id', $request->ticket_id)->where('id', $request->image_id)->delete();

            $ticket_images = TransportationTicketImages::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'ticket_images' => $ticket_images,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
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
            $dateLimit = getApiRecordLimitDate();
            $transportation_ticket_list = TransportationTicketModel::where('user_id', $request->user_id)
                                                                    ->whereDate('created_at', '>=', $dateLimit)
                                                                    ->with(['ticketImages','shippers','customers'])
                                                                    ->get();
            
            if($transportation_ticket_list) {
                return response()->json([
                    'success' => true,
                    'total' => count($transportation_ticket_list),
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

            $ticket_detail = TransportationTicketModel::where('id', $request->ticket_id)->with(['ticketImages','shippers','customers'])->first();
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


    /* ======================= Transportation Ticket Shipper ========================== */

    // public function add_transportation_shipper(Request $request)
    // {
    //     $request->merge([
    //         'shipper_time_in' => $request->input('shipper_time_in') != null ? date('H:i', strtotime($request->input('shipper_time_in'))) : null,
    //         'shipper_time_out' => $request->input('shipper_time_out') != null ? date('H:i', strtotime($request->input('shipper_time_out'))) : null,
    //     ]);
       
    //     $validator = Validator::make($request->all(), [
    //         'ticket_id' => 'required|exists:transportation_tickets,id',
    //         'shipper_name' => 'required|string|max:100',
    //         'shipper_signature' => 'required|string',
    //         'shipper_signature_date' => 'required|date',
    //         'shipper_time_in' => 'required|date_format:H:i',
    //         'shipper_time_out' => 'required|date_format:H:i',
    //     ]);
    
    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     try {
    //         $record = new TransportationTicketShipper; 
    //         $record->ticket_id = $request->ticket_id;
    //         $record->shipper_name = $request->shipper_name;
    //         $record->shipper_signature = $request->shipper_signature;
    //         $record->shipper_signature_date = $request->shipper_signature_date;
    //         $record->shipper_time_in = $request->shipper_time_in;
    //         $record->shipper_time_out = $request->shipper_time_out;
    //         $record->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Shipper added successfully...'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Log the error for debugging purposes
    //         Log::error('Error adding record: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Oops! Network Error",
    //         ], 500);
    //     }
    // }

    // public function update_transportation_shipper(Request $request)
    // {
    //     $request->merge([
    //         'shipper_time_in' => $request->input('shipper_time_in') != null ? date('H:i', strtotime($request->input('shipper_time_in'))) : null,
    //         'shipper_time_out' => $request->input('shipper_time_out') != null ? date('H:i', strtotime($request->input('shipper_time_out'))) : null,
    //     ]);
    //     $validator = Validator::make($request->all(), [
    //         'shipper_id' => 'required|exists:transportation_ticket_shippers,id',
    //         'ticket_id' => 'required|exists:transportation_tickets,id',
    //         'shipper_name' => 'required|string|max:100',
    //         'shipper_signature' => 'required|string',
    //         'shipper_signature_date' => 'required|date',
    //         'shipper_time_in' => 'required|date_format:H:i',
    //         'shipper_time_out' => 'required|date_format:H:i',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     try {
    //         $record = TransportationTicketShipper::where('id', $request->shipper_id)->first();
    //         if($record){
    //             $record->ticket_id = $request->ticket_id;
    //             $record->shipper_name = $request->shipper_name;
    //             $record->shipper_signature = $request->shipper_signature;
    //             $record->shipper_signature_date = $request->shipper_signature_date;
    //             $record->shipper_time_in = $request->shipper_time_in;
    //             $record->shipper_time_out = $request->shipper_time_out;
    //             $record->save();
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Shipper updated successfully...'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Log the error for debugging purposes
    //         Log::error('Error adding record: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Oops! Network Error",
    //         ], 500);
    //     }
    // }

    public function delete_shipper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'shipper_id' => 'required|numeric',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            TransportationTicketShipper::where('ticket_id', $request->ticket_id)->where('id', $request->shipper_id)->delete();

            $shippers = TransportationTicketShipper::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Shipper deleted successfully...',
                'shippers' => $shippers,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error loading job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function get_specific_shipper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipper_id' => 'required|exists:transportation_ticket_shippers,id',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $shipper_detail = TransportationTicketShipper::where('id', $request->shipper_id)->first();
            if($shipper_detail) {
                return response()->json([
                    'success' => true,
                    'shipper_detail' => $shipper_detail,
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

    /* ======================= Transportation Ticket Customer ========================== */

    // public function add_transportation_customer(Request $request)
    // {
    //     $request->merge([
    //         'customer_time_in' => $request->input('customer_time_in') != null ? date('H:i', strtotime($request->input('customer_time_in'))) : null,
    //         'customer_time_out' => $request->input('customer_time_out') != null ? date('H:i', strtotime($request->input('customer_time_out'))) : null,
    //     ]);
       
    //     $validator = Validator::make($request->all(), [
    //         'ticket_id' => 'required|exists:transportation_tickets,id',
    //         'customer_name' => 'required|string|max:100',
    //         'customer_email' => 'required|string|email|max:100',
    //         'customer_signature' => 'required|string',
    //         'customer_signature_date' => 'required|date',
    //         'customer_time_in' => 'required|date_format:H:i',
    //         'customer_time_out' => 'required|date_format:H:i',
    //     ], [
    //         'ticket_id.required' => 'The transportation ticket ID is required.',
    //         'ticket_id.exists' => 'The selected transportation ticket does not exist.',

    //         'customer_name.required' => 'The consignee name is required.',
    //         'customer_name.max' => 'The consignee name must not be greater than 100 characters.',
        
    //         'customer_email.required' => 'The consignee email is required.',
    //         'customer_email.email' => 'The consignee email must be a valid email address.',
    //         'customer_email.max' => 'The consignee email must not be greater than 100 characters.',
        
    //         'customer_signature.required' => 'The consignee signature is required.',
    //         'customer_signature.string' => 'The consignee signature must be a valid string.',
        
    //         'customer_signature_date.required' => 'The consignee signature date is required.',
    //         'customer_signature_date.date' => 'The consignee signature date must be a valid date.',
        
    //         'customer_time_in.required' => 'The consignee time in is required.',
    //         'customer_time_in.date_format' => 'The consignee time in must be in the format HH:MM.',
        
    //         'customer_time_out.required' => 'The consignee time out is required.',
    //         'customer_time_out.date_format' => 'The consignee time out must be in the format HH:MM.',
    //     ]);
    
    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     try {
    //         $record = new TransportationTicketCustomer; 
    //         $record->ticket_id = $request->ticket_id;
    //         $record->customer_name = $request->customer_name;
    //         $record->customer_email = $request->customer_email;
    //         $record->customer_signature = $request->customer_signature;
    //         $record->customer_signature_date = $request->customer_signature_date;
    //         $record->customer_time_in = $request->customer_time_in;
    //         $record->customer_time_out = $request->customer_time_out;
    //         $record->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Consignee added successfully...'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Log the error for debugging purposes
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Oops! Network Error",
    //         ], 500);
    //     }
    // }

    // public function update_transportation_customer(Request $request)
    // {
    //     $request->merge([
    //         'customer_time_in' => $request->input('customer_time_in') != null ? date('H:i', strtotime($request->input('customer_time_in'))) : null,
    //         'customer_time_out' => $request->input('customer_time_out') != null ? date('H:i', strtotime($request->input('customer_time_out'))) : null,
    //     ]);
       
    //     $validator = Validator::make($request->all(), [
    //         'ticket_id' => 'required|exists:transportation_tickets,id',
    //         'customer_id' => 'required|exists:transportation_ticket_customers,id',
    //         'customer_name' => 'required|string|max:100',
    //         'customer_email' => 'required|string|email|max:100',
    //         'customer_signature' => 'required|string',
    //         'customer_signature_date' => 'required|date',
    //         'customer_time_in' => 'required|date_format:H:i',
    //         'customer_time_out' => 'required|date_format:H:i',
    //     ], [
    //         'ticket_id.required' => 'The transportation ticket ID is required.',
    //         'ticket_id.exists' => 'The selected transportation ticket does not exist.',
        
    //         'customer_id.required' => 'The consignee ID is required.',
    //         'customer_id.exists' => 'The selected consignee does not exist.',
        
    //         'customer_name.required' => 'The consignee name is required.',
    //         'customer_name.string' => 'The consignee name must be a valid string.',
    //         'customer_name.max' => 'The consignee name must not be greater than 100 characters.',
        
    //         'customer_email.required' => 'The consignee email is required.',
    //         'customer_email.string' => 'The consignee email must be a valid string.',
    //         'customer_email.email' => 'The consignee email must be a valid email address.',
    //         'customer_email.max' => 'The consignee email must not be greater than 100 characters.',
        
    //         'customer_signature.required' => 'The consignee signature is required.',
    //         'customer_signature.string' => 'The consignee signature must be a valid string.',
        
    //         'customer_signature_date.required' => 'The consignee signature date is required.',
    //         'customer_signature_date.date' => 'The consignee signature date must be a valid date.',
        
    //         'customer_time_in.required' => 'The consignee time in is required.',
    //         'customer_time_in.date_format' => 'The consignee time in must be in the format HH:MM.',
        
    //         'customer_time_out.required' => 'The consignee time out is required.',
    //         'customer_time_out.date_format' => 'The consignee time out must be in the format HH:MM.',
    //     ]);
        

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     try {
    //         $record = TransportationTicketCustomer::where('id', $request->customer_id)->first();
    //         if($record){
    //             $record->ticket_id = $request->ticket_id;
    //             $record->customer_name = $request->customer_name;
    //             $record->customer_email = $request->customer_email;
    //             $record->customer_signature = $request->customer_signature;
    //             $record->customer_signature_date = $request->customer_signature_date;
    //             $record->customer_time_in = $request->customer_time_in;
    //             $record->customer_time_out = $request->customer_time_out;
    //             $record->save();
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Consignee updated successfully...'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Log the error for debugging purposes
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Oops! Network Error",
    //         ], 500);
    //     }
    // }

    public function delete_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:transportation_tickets,id',
            'customer_id' => 'required|exists:transportation_ticket_customers,id',
        ], [
            'ticket_id.required' => 'The transportation ticket ID is required.',
            'ticket_id.exists' => 'The selected transportation ticket does not exist.',
        
            'customer_id.required' => 'The consignee ID is required.',
            'customer_id.exists' => 'The selected consignee does not exist.'
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            TransportationTicketCustomer::where('ticket_id', $request->ticket_id)->where('id', $request->customer_id)->delete();

            $customers = TransportationTicketCustomer::where('ticket_id', $request->ticket_id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Shipper deleted successfully...',
                'customers' => $customers,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function get_specific_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:transportation_ticket_customers,id',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $customer_detail = TransportationTicketCustomer::where('id', $request->customer_id)->first();
            if($customer_detail) {
                return response()->json([
                    'success' => true,
                    'customer_detail' => $customer_detail,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Data Found',
                ], 401);
            }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    

    public function sendEmailTransporterTicket($ticket_id){

        $ticketDetail = TransportationTicketModel::where('id', $ticket_id)->first();

        if($ticketDetail->status == '3'){       // if status is (3) completed  then send email
            
            $attachment_pdf = $this->makeTicketPDF($ticket_id);

            if($attachment_pdf){
            
                $transporterDetail = User::where('id', $ticketDetail->created_by)->first(); // created or rigger details

                $jobDetail = JobModel::where('id', $ticketDetail->job_id)->first(); // lnked job details
            
                if($jobDetail){
                    
                    $managerDetail = User::where('id', $jobDetail->created_by)->first(); // manager/createby details

                    $riggerAssignedIds = json_decode($jobDetail->rigger_assigned); 
                    $assignedUsers = User::whereIn('id', $riggerAssignedIds)->where('status', '1')->pluck('name')->toArray();
                    $assignedUserNames = implode(', ', $assignedUsers);
                    // assigned job emails
                    $assignedUsers = User::whereIn('id', $riggerAssignedIds)->where('status', '1')->get();// assigned user details

                    if($ticketDetail->status == '1'){
                        $status_txt = 'Draft';
                    }else if($ticketDetail->status == '2'){
                        $status_txt = 'Issued';
                    }else if($ticketDetail->status == '3'){
                        $status_txt = 'Completed';
                    }else{
                        $status_txt = '';
                    }
                    
                    $mailData = [];
                    
                    $mailData['user'] = $managerDetail->name;
                    $mailData['transporter_name'] = $transporterDetail->name;
                    $mailData['assigned_user_names'] = $assignedUserNames;
                    $mailData['job_number'] = 'J-'.$ticketDetail->job_id;
                    $mailData['ticket_number'] = 'TTKT-'.$ticketDetail->id;
                    $mailData['pickup_address'] = $ticketDetail->pickup_address;
                    $mailData['delivery_address'] = $ticketDetail->delivery_address;

                    $mailData['po_number'] = $ticketDetail->po_number;
                    $mailData['ticket_date'] = $ticketDetail->created_at != null ? date('d-M-Y', strtotime($ticketDetail->created_at)) : '';
                    $mailData['time_in'] = $ticketDetail->time_in != null ? date('H:i A', strtotime($ticketDetail->time_in)) : '';
                    $mailData['time_out'] = $ticketDetail->time_out != null ? date('H:i A', strtotime($ticketDetail->time_out)) : '';
                    $mailData['status'] = $status_txt;
    
                    $mailData['text1'] = "New Transporter Ticket has been created. Ticket details are as under.";
                    $mailData['text2'] = "For more details please contact the Manager/Admin.";
    
                    // $body = view('emails.transporter_ticket_template', $mailData);
                    // $userEmailsSend = $managerDetail->email;//'hamza@5dsolutions.ae';//
                    // sendMailAttachment($managerDetail->name, $userEmailsSend, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);

                    if($jobDetail->job_type != 3){
                        foreach($assignedUsers as $user){
                            $mailData['user'] = $user->name;
                            $body = view('emails.transporter_ticket_template', $mailData);
                            sendMailAttachment($user->name, $user->email, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);
                        }
                    }

                    if(isset($ticketDetail->customer_email) && $ticketDetail->customer_email != null){
                        $mailData['user'] = $ticketDetail->customer_name;
                        $body = view('emails.transporter_ticket_template', $mailData);
                        sendMailAttachment($ticketDetail->customer_name, $ticketDetail->customer_email, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);
                    }
                    
                    // push notification entry
                    $Notifications = new Notifications();
                    $Notifications->module_code = 'TRANSPORTER TICKET SUBMITTED';
                    $Notifications->from_user_id = $transporterDetail->id;
                    $Notifications->to_user_id = '1';   // for super admin
                    $Notifications->subject = 'Transporter Ticket Submitted';
                    $Notifications->message = 'Transporter Ticket TTKT-'.$ticketDetail->id.' on '.$ticketDetail->created_at != null ? date('d-M-Y', strtotime($ticketDetail->created_at)) : ''.' has been submitted by '.$transporterDetail->name.'.';
                    $Notifications->message_html = $body;
                    $Notifications->read_flag = '0';
                    $Notifications->created_by = $transporterDetail->id;
                    $Notifications->created_at = date('Y-m-d H:i:s');
                    $Notifications->save();
                    
                    // $allAdmins = User::whereIn('role_id', ['0','1'])->where('status', '1')->get();

                    // if($allAdmins){
                    //     foreach($allAdmins as $value){
                    //         $mailData['user'] = $value->name;
                    //         $body = view('emails.transporter_ticket_template', $mailData);
                    //         $userEmailsSend = $value->email;//'hamza@5dsolutions.ae';//
                    //         sendMailAttachment($value->name, $userEmailsSend, 'Superior Crane', 'Transporter Ticket Creation', $body, $attachment_pdf);
                    //     }
                    // }
                }
            }
        }
    }
    
    public function makeTicketPDF($ticket_id='')
    {

        $id = $ticket_id;
        $filepath = public_path('assets/pdf/pdf_samples/transporter_ticket.pdf');
        $output_file_path = public_path('assets/pdf/transporter_ticket_pdfs/ticket_' .$id. '.pdf'); 
        $ticket = TransportationTicketModel::find($id);
        if($ticket){
            $fields = [
                ['text' => 'TTKT-'.$ticket->id, 'x' => 245, 'y' => 13],
                ['text' => $ticket->pickup_address, 'x' => 58, 'y' => 33, 'width' => 210, 'height' => 6],
                ['text' => $ticket->delivery_address, 'x' => 58, 'y' => 41, 'width' => 210, 'height' => 6],
                // ['text' => $ticket->delivery_address, 'x' => 58, 'y' => 49, 'width' => 210, 'height' => 6],
                
                ['text' => $ticket->job_number, 'x' => 58, 'y' => 65],
                ['text' => $ticket->job_special_instructions, 'x' => 105, 'y' => 66, 'width' => 170, 'height' => 6],

                ['text' => $ticket->po_number, 'x' => 58, 'y' => 71],
                ['text' => $ticket->po_special_instructions, 'x' => 105, 'y' => 72, 'width' => 170, 'height' => 6],

                ['text' => $ticket->site_contact_name, 'x' => 58, 'y' => 76],
                ['text' => $ticket->site_contact_name_special_instructions, 'x' => 105, 'y' => 77, 'width' => 170, 'height' => 6],

                ['text' => $ticket->site_contact_number, 'x' => 58, 'y' => 81],
                ['text' => $ticket->site_contact_number_special_instructions, 'x' => 105, 'y' => 82, 'width' => 170, 'height' => 6],


                ['text' => $ticket->shipper_name, 'x' => 58, 'y' => 96.5],
                // ['base64_image' => $ticket->shipper_signature, 'x' => 122, 'y' => 98, 'width' => 20, 'height' => 5],
                ['text' => $ticket->shipper_signature_date != null ? date('d-M-Y', strtotime($ticket->shipper_signature_date)) : '', 'x' => 164, 'y' => 96.5],
                ['text' => $ticket->shipper_time_in != null ? date('H:i', strtotime($ticket->shipper_time_in)) : '', 'x' => 210, 'y' => 96.5],
                ['text' => $ticket->shipper_time_out, 'x' => 241, 'y' => 96.5],

                ['text' => $ticket->pickup_driver_name, 'x' => 58, 'y' => 103],
                ['base64_image' => $ticket->pickup_driver_signature, 'x' => 122, 'y' => 104.5, 'width' => 20, 'height' => 5],
                ['text' => $ticket->pickup_driver_signature_date != null ? date('d-M-Y', strtotime($ticket->pickup_driver_signature_date)) : '', 'x' => 164, 'y' => 103],
                ['text' => $ticket->pickup_driver_time_in != null ? date('H:i', strtotime($ticket->pickup_driver_time_in)) : '', 'x' => 210, 'y' => 103],
                ['text' => $ticket->pickup_driver_time_out, 'x' => 241, 'y' => 103],

                ['text' => $ticket->customer_name, 'x' => 58, 'y' => 110],
                // ['base64_image' => $ticket->customer_signature, 'x' => 122, 'y' => 111, 'width' => 20, 'height' => 5],
                ['text' => $ticket->customer_signature_date != null ? date('d-M-Y', strtotime($ticket->customer_signature_date)) : '', 'x' => 164, 'y' => 110],
                ['text' => $ticket->customer_time_in != null ? date('H:i', strtotime($ticket->customer_time_in)) : '', 'x' => 210, 'y' => 110],
                ['text' => $ticket->customer_time_out, 'x' => 241, 'y' => 110],
                
            ];
    
            $outputFile = $this->editPdf($filepath, $output_file_path, $fields);
            
            return $outputFile;//'/public'.
        }else{
            return false;
        }
        
    }

    public function editPdf($file, $output_file, $fields)
    {
        $fpdi = new Fpdi();
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);

            $fpdi->SetFont('Helvetica', '', 10);
            foreach ($fields as $field) {
                $fpdi->SetXY($field['x'], $field['y']);
                
                if(isset($field['base64_image'])){
                    if($field['base64_image'] != '' && $field['base64_image'] != null){
                        // Decode the base64 image
                        $imageData = base64_decode($field['base64_image']);
                        $image = imagecreatefromstring($imageData);
                
                        // Convert the image to 8-bit or 24-bit format
                        if ($image !== false) {
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'sig_') . '.png';
                            
                            // Save the image in 24-bit format
                            imagepng($image, $tempFilePath);
                            imagedestroy($image);
                
                            // Add the image to the PDF
                            $fpdi->Image($tempFilePath, $field['x'], $field['y'], $field['width'], $field['height']);
                
                            // Remove the temporary file
                            unlink($tempFilePath);
                        } else {
                            throw new Exception('Invalid image data');
                        }
                    } else {
                        $fpdi->Write(8, '');
                    }
                }else{

                    if(isset($field['font'])){
                        $fpdi->SetFont('Helvetica', '', $field['font']);
                    }else{
                        $fpdi->SetFont('Helvetica', '', 10);
                    }
                    
                    if (isset($field['width']) && isset($field['height'])) {
                        $fpdi->MultiCell($field['width'], $field['height'], isset($field['text']) ? $field['text'] : '');
                    } else if(isset($field['text'])){
                        $fpdi->Write(8, isset($field['text']) ? $field['text'] : '');
                    }else{
                        $fpdi->Write(8, '');
                    }
                }
            }
        }

        $fpdi->Output($output_file, 'F');
        
        return $output_file;
    }
}
