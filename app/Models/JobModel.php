<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    use HasFactory;

    protected $table = "jobs";
    
    // protected $casts = [
    //     'rigger_assigned' => 'array',
    // ];
    
    public function userAssigned()
    {
        return $this->belongsTo(User::class, 'rigger_assigned');
    }
    // public function userAssigned()
    // {
    //     $userIds = json_decode($this->rigger_assigned, true);

    //     if (is_array($userIds)) {
    //         return User::whereIn('id', $userIds)->get();
    //     }

    //     return collect(); // Return an empty collection if no IDs are found
    // }
    

    public function jobImages()
    {
    	return $this->hasMany(JobImages::class, 'job_id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function riggerTicket()
    {
        return $this->hasOne(RiggerTicket::class, 'job_id');
    }

    public function transporterTicket()
    {
        return $this->hasOne(TransportationTicketModel::class, 'job_id');
    }
}
