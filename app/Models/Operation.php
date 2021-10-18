<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{

    use HasFactory, Filterable;

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

    public function operationType(){
        return $this->belongsTo(OperationType::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByPendingTaskIds($query, array $ids){
        return $query->whereIn('pending_task_id', $ids);
    }

    public function scopeByOperationTypeIds($query, array $ids){
        return $query->whereIn('operation_type_id', $ids);
    }
}
