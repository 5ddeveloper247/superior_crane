<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\User;
use App\Models\JobModel;

class ArchiveTransportationTicketsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Return the column headings based on your JSON data
        return ['Transportation Ticket ID',
                'User Name',
                'Job Client Name',
                'Pickup Address',
                'Delivery Address',
                'Time-In',
                'Time-Out',
                'Notes',
                'Job Number',
                'Job Special Instructions',
                'PO Number',
                'PO Special Instructions',
                'Site Contact Name',
                'Site Contact Instructions',
                'Site Contact Number',
                'Site Contact Number Instructions',
                'Shipper Name',
                'Shipper Signature',
                'Shipper Signature date',
                'Shipper Time-In',
                'Shipper Time-Out',
                'Pickup Driver Name',
                'Pickup Driver Signature',
                'Pickup Driver Signature Date',
                'Pickup Driver Time-in',
                'Pickup Driver Time-Out',
                'customer Name',
                'Customer Email',
                'Customer Signature',
                'Customer Signature Date',
                'Customer Time-In',
                'Customer Time-Out',
                'Status',
                'Change Status Reason',
                'Created At']; 
    }
    
    public function map($row): array
    {

        $userName = User::where('id', $row['user_id'])->pluck('name')->first();
        $jobClientName = JobModel::where('id', $row['job_id'])->pluck('client_name')->first();

        // status
        if($row['status'] == '1'){
            $status_txt = 'Draft'; 
        }else if($row['status'] == '2'){
            $status_txt = 'Issued';
        }else if($row['status'] == '3'){
            $status_txt = 'Completed';
        }else{
            $status_txt = '';
        }

        // Map the JSON data to match your column structure
        return [
            $row['id'] ?? '',
            $userName ?? '',
            $jobClientName ?? '',
            $row['pickup_address'] ?? '',
            $row['delivery_address'] ?? '',
            $row['time_in'] ?? '',
            $row['time_out'] ?? '',
            $row['notes'] ?? '',
            $row['job_number'] ?? '',
            $row['job_special_instructions'] ?? '',
            $row['po_number'] ?? '',
            $row['po_special_instructions'] ?? '',
            $row['site_contact_name'] ?? '',
            $row['site_contact_name_special_instructions'] ?? '',
            $row['site_contact_number'] ?? '',
            $row['site_contact_number_special_instructions'] ?? '',
            $row['shipper_name'] ?? '',
            $row['shipper_signature'] ?? '',
            $row['shipper_signature_date'] ?? '',
            $row['shipper_time_in'] ?? '',
            $row['shipper_time_out'] ?? '',
            $row['pickup_driver_name'] ?? '',
            $row['pickup_driver_signature'] ?? '',
            $row['pickup_driver_signature_date'] ?? '',
            $row['pickup_driver_time_in'] ?? '',
            $row['pickup_driver_time_out'] ?? '',
            $row['customer_name'] ?? '',
            $row['customer_email'] ?? '',
            $row['customer_signature'] ?? '',
            $row['customer_signature_date'] ?? '',
            $row['customer_time_in'] ?? '',
            $row['customer_time_out'] ?? '',
            $status_txt ?? '',
            $row['change_status_reason'] ?? '',
            $row['created_at'] ?? '',
        ];
    }
}