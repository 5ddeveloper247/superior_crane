<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayDutyModel extends Model
{
    use HasFactory;
    protected $table="pay_duty_form";
    
    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function dutyImages()
    {
    	return $this->hasMany(PayDutytImages::class, 'pay_duty_id');
    }
}
