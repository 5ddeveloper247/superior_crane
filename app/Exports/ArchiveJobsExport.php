<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\User;


class ArchiveJobsExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Job ID', 
                'Job Type', 
                'Client Name', 
                'Job Date', 
                'Job Time', 
                'Address', 
                'Equipment to be used', 
                'Rigger Assigned', 
                'User Assigned', 
                'Supplier Name', 
                'Notes', 
                'Job Status', 
                'Created At']; 
    }
    
    public function map($row): array
    {
        // job type
        if($row['job_type'] == '1'){
            $job_type = 'Logistic Job(SCCI)';  
        }else if($row['job_type'] == '2'){
            $job_type = 'Crane Job';  
        }else{
            $job_type = 'Other Job';  
        }

        // status
        if($row['status'] == '0'){
            $status_txt = 'Problem';
        }else if($row['status'] == '1'){
            $status_txt = 'Good To Go'; 
        }else if($row['status'] == '2'){
            $status_txt = 'On-Hold';
        }else if($row['status'] == '3'){
            $status_txt = 'Completed';
        }else{
            $status_txt = '';
        }

        $riggerNames = '';
        if (isset($row['rigger_assigned']) && !empty($row['rigger_assigned'])) {
            $userIds = json_decode($row['rigger_assigned'], true); // Decode the JSON array of user IDs
            $riggerNames = User::whereIn('id', $userIds)->pluck('name')->join(', '); // Fetch names and join them with commas
        }

        // Map the JSON data to match your column structure
        return [
            $row['id'] ?? '',
            $job_type ?? '',
            $row['client_name'] ?? '',
            $row['date'] ?? '',
            $row['start_time'] ?? '',
            $row['address'] ?? '',
            $row['equipment_to_be_used'] ?? '',
            $riggerNames ?? '',
            $row['user_assigned'] ?? '',
            $row['supplier_name'] ?? '',
            $row['notes'] ?? '',
            $status_txt ?? '',
            $row['created_at'] ?? '',
        ];
    }
}