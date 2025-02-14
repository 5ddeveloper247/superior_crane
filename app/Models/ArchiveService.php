<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveService extends Model
{
    use HasFactory;

    public function archive_job()
    {
        return $this->hasOne(ArchiveJob::class, 'service_id');
    }
}
