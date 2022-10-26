<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatePendingTask extends Model
{

    use HasFactory;

    const PENDING = 1;
    const IN_PROGRESS = 2;
    const FINISHED = 3;
    const CANCELED = 4;

    protected $fillable = [
        'name'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'state_pending_task_id');
    }
}
