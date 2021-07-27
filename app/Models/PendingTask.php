<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Task;
use App\Models\StatePendingTask;
use App\Models\GroupTask;
use App\Models\Incidence;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingTask extends Model
{

    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'state_pending_task_id',
        'group_task_id',
        'duration',
        'order',
        'approved',
        'code_authorization',
        'status_color',
        'datetime_pending',
        'datetime_start',
        'datetime_finish'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function state_pending_task(){
        return $this->belongsTo(StatePendingTask::class, 'state_pending_task_id');
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class, 'group_task_id');
    }

    public function incidences(){
        return $this->belongsToMany(Incidence::class);
    }

    public function pending_task_canceled(){
        return $this->hasMany(PendingTaskCanceled::class);
    }

}
