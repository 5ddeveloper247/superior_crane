<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationTicketShipper extends Model
{
    use HasFactory;

    protected $table = "transportation_ticket_shippers";

    protected $fillable = [
        'id',
        'ticket_id',
        'shipper_name',
        'shipper_signature',
        'shipper_signature_date',
        'shipper_time_in',
        'shipper_time_out',
        'created_at',
        'updated_at'
    ];
    
}
