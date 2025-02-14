<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\User;
use App\Models\JobModel;

class ArchiveRiggerTicketsExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Rigger Ticket ID',
                'User Name',
                'Job Client Name',
                'Specifications Remarks',
                'Customer Name',
                'Location',
                'Po Number',
                'Date',
                'Leave Yard',
                'Start Job',
                'Finish Job',
                'Arrival Yard',
                'Lunch',
                'Travel Time',
                'Crane Time',
                'Total Hours',
                'Crane Number',
                'Rating',
                'Boom Length',
                'Operator',
                'Other Equipment',
                'Email',
                'Notes',
                'Signature',
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
            $row['specifications_remarks'] ?? '',
            $row['customer_name'] ?? '',
            $row['location'] ?? '',
            $row['po_number'] ?? '',
            $row['date'] ?? '',
            $row['leave_yard'] ?? '',
            $row['start_job'] ?? '',
            $row['finish_job'] ?? '',
            $row['arrival_yard'] ?? '',
            $row['lunch'] ?? '',
            $row['travel_time'] ?? '',
            $row['crane_time'] ?? '',
            $row['total_hours'] ?? '',
            $row['crane_number'] ?? '',
            $row['rating'] ?? '',
            $row['boom_length'] ?? '',
            $row['operator'] ?? '',
            $row['other_equipment'] ?? '',
            $row['email'] ?? '',
            $row['notes'] ?? '',
            $row['signature'] ?? '',
            $status_txt ?? '',
            $row['change_status_reason'] ?? '',
            $row['created_at'] ?? '',
        ];
    }
}