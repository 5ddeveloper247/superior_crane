<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveRiggerTicket extends Model
{
    use HasFactory;
    protected $table = "archive_rigger_tickets";
    protected $fillable = [
        'service_id',    
        'json_data',        
        'created_at',        
        'updated_at',       
    ];

}
