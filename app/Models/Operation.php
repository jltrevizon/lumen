<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{

    protected $fillable = [
        'vehicle_id',
        'pending_task_id',
        'operation_type_id',
        'description'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function operatioType(){
        return $this->belongsTo(OperationType::class);
    }
}
