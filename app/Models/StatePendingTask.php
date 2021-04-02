<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;

class StatePendingTask extends Model
{
    public function pending_tasks(){
        return $this->hasMany(PendingTask::class, 'state_pending_task_id');
    }
}
