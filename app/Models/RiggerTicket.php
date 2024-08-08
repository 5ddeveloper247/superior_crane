<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiggerTicket extends Model
{
    use HasFactory;
    protected $table = "rigger_tickets";
    

    public function jobDetail()
    {
        return $this->belongsTo(JobModel::class, 'job_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticketImages()
    {
    	return $this->hasMany(RiggerTicketImages::class, 'ticket_id');
    }
}
