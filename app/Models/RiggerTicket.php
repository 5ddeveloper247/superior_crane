<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiggerTicket extends Model
{
    use HasFactory;
    protected $table = "rigger_tickets";
    protected $fillable = [
        'user_id',
        'specifications_remarks',
        'customer_name',
        'location',
        'po_number',
        'date',
        'leave_yard',
        'start_job',
        'finish_job',
        'arrival_yard',
        'lunch',
        'travel_time',
        'crane_time',
        'total_hours',
        'crane_number',
        'rating',
        'boom_length',
        'operator',
        'other_equipment',
        'email',
        'notes',
        'signature',
        'site_pic',
        'created_by',
    ];

    public function ticketImages()
    {
    	return $this->hasMany(RiggerTicketImages::class, 'ticket_id');
    }
}
