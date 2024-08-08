<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    use HasFactory;

    protected $table = "jobs";
    
    
    public function userAssigned()
    {
        return $this->belongsTo(User::class, 'rigger_assigned');
    }

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
}
