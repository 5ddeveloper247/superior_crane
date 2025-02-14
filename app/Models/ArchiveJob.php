<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveJob extends Model
{
    use HasFactory;

    protected $table = "archive_jobs";
    protected $fillable = [
        'service_id',
        'json_data',    
        'created_at',        
        'updated_at',       
    ];

    public function service()
    {
        return $this->belongsTo(ArchiveService::class, 'service_id');
    }
    
}
