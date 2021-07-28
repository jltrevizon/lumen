<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\TypeTask;
use App\Models\PurchaseOperation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{

    use HasFactory;

    const UBICATION = 1;

    protected $fillable = [
        'sub_state_id',
        'type_task_id',
        'name',
        'duration'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'task_id');
    }

    public function subState(){
        return $this->belongsTo(SubState::class, 'sub_state_id');
    }

    public function typeTask(){
        return $this->belongsTo(TypeTask::class, 'type_task_id');
    }

    public function purchaseOperations(){
        return $this->hasMany(PurchaseOperation::class, 'task_id');
    }
}
