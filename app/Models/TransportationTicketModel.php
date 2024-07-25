<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationTicketModel extends Model
{
    use HasFactory;
    protected $table ="transportation_tickets";
    protected $fillable = [
        'pickup_address',
        'delivery_address',
        'time_in',
        'time_out',
        'notes',
        'job_number',
        'job_special_instructions',
        'po_number',
        'po_special_instructions',
        'site_contact_name',
        'site_contact_name_special_instructions',
        'site_contact_number',
        'site_contact_number_special_instructions',
        'shipper_name',
        'shipper_signature',
        'shipper_signature_date',
        'shipper_time_in',
        'shipper_time_out',
        'pickup_driver_name',
        'pickup_driver_signature',
        'pickup_driver_signature_date',
        'pickup_driver_time_in',
        'pickup_driver_time_out',
        'customer_name',
        'customer_email',
        'customer_signature',
        'customer_signature_date',
        'customer_time_in',
        'customer_time_out',
        'signed_status',
        'site_pic',
        'created_by',
    ];
}
