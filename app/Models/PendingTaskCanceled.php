<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingTaskCanceled extends Model
{
    use HasFactory;

    protected $fillable = [
        'pending_task_id',
        'description'
    ];

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }
}
