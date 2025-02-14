<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivePayDutyForm extends Model
{
    use HasFactory;
    protected $table = "archive_pay_duty_forms";
    protected $fillable = [
        'service_id',    
        'json_data',        
        'created_at',        
        'updated_at',       
    ];

}
