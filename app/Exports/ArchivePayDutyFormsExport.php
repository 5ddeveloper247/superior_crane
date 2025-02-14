<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\User;
use App\Models\RiggerTicket;

class ArchivePayDutyFormsExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Pay Duty ID',
                'User Name',
                'Customer Name',
                'Date',
                'Location',
                'Start Time',
                'Finish Time',
                'Total Hours',
                'Officer',
                'Officer Name',
                'Division',
                'Email',
                'Signature',
                'Status',
                'Change Status Reason',
                'Created At']; 
    }
    
    public function map($row): array
    {

        $userName = User::where('id', $row['user_id'])->pluck('name')->first();
        $customerName = RiggerTicket::where('id', $row['rigger_ticket_id'])->pluck('customer_name')->first();

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
            $customerName ?? '',
            $row['date'] ?? '',
            $row['location'] ?? '',
            $row['start_time'] ?? '',
            $row['finish_time'] ?? '',
            $row['total_hours'] ?? '',
            $row['officer'] ?? '',
            $row['officer_name'] ?? '',
            $row['division'] ?? '',
            $row['email'] ?? '',
            $row['signature'] ?? '',
            $status_txt ?? '',
            $row['change_status_reason'] ?? '',
            $row['created_at'] ?? '',
        ];
    }
}