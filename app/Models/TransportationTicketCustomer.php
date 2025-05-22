<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationTicketCustomer extends Model
{
    use HasFactory;

    protected $table = "transportation_ticket_customers";

    protected $fillable = [
        'id',
        'ticket_id',
        'customer_name',
        'customer_email',
        'customer_signature',
        'customer_signature_date',
        'customer_time_in',
        'customer_time_out',
        'created_at',
        'updated_at'
    ];
}
