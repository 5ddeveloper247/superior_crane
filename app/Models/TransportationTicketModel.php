<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationTicketModel extends Model
{
    use HasFactory;
    protected $table ="transportation_tickets";
    
    public function jobDetail()
    {
        return $this->belongsTo(JobModel::class, 'job_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shippers()
    {
    	return $this->hasMany(TransportationTicketShipper::class, 'ticket_id');
    }

    public function customers()
    {
    	return $this->hasMany(TransportationTicketCustomer::class, 'ticket_id');
    }

    public function ticketImages()
    {
    	return $this->hasMany(TransportationTicketImages::class, 'ticket_id');
    }
}
