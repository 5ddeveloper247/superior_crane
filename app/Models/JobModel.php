<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    use HasFactory;

    protected $table = "jobs";
    protected $fillable = [
        'client_name','job_time','date','address','equipment_to_be_used','rigger_assigned','supplier_name','notes','job_image','scci','created_by','status'
    ];
    
    
}
