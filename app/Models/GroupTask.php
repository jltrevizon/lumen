<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\Vehicle;

class GroupTask extends Model
{
    public function pending_tasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'group_task_id');
    }
}
