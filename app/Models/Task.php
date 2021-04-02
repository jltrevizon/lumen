<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\TypeTask;
use App\Models\PurchaseOperation;

class Task extends Model
{
    public function pending_tasks(){
        return $this->hasMany(PendingTask::class, 'task_id');
    }

    public function sub_state(){
        return $this->belongsTo(SubState::class, 'sub_state_id');
    }

    public function type_task(){
        return $this->belongsTo(TypeTask::class, 'type_task_id');
    }

    public function purchase_operations(){
        return $this->hasMany(PurchaseOperation::class, 'task_id');
    }
}
