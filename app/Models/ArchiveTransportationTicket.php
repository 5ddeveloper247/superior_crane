<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveTransportationTicket extends Model
{
    use HasFactory;
    protected $table = "archive_transportation_tickets";
    protected $fillable = [
        'service_id',    
        'json_data',        
        'created_at',        
        'updated_at',       
    ];

}
