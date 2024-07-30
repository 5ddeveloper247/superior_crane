<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayDutyModel extends Model
{
    use HasFactory;
    protected $table="pay_duty_form";
    protected $fillable = [
        'date',
        'location',
        'start_time',
        'finish_time',
        'total_hours',
        'officer',
        'officer_name',
        'division',
        'email',
        'signature',
        'site_pic',
        'created_by',
    ];

    public function dutyImages()
    {
    	return $this->hasMany(PayDutytImages::class, 'pay_duty_id');
    }
}
