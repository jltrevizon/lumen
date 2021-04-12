<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Task;
use App\Models\StatePendingTask;
use App\Models\GroupTask;
use App\Models\Incidence;

class PendingTask extends Model
{
    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function state_pending_task(){
        return $this->belongsTo(StatePendingTask::class, 'state_pending_task_id');
    }

    public function group_task(){
        return $this->belongsTo(GroupTask::class, 'group_task_id');
    }

    public function incidence(){
        return $this->belongsTo(Incidence::class, 'incidence_id');
    }
}
