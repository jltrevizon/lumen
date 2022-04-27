<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimatedDate extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'pending_task_id',
        'estimated_date',
        'reason'
    ];

    public function pendingTask()
    {
        return $this->belongsTo(PendingTask::class);
    }

}
