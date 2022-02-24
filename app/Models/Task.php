<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\TypeTask;
use App\Models\PurchaseOperation;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{

    use HasFactory, Filterable;

    const UBICATION = 1;

    protected $fillable = [
        'company_id',
        'sub_state_id',
        'type_task_id',
        'need_authorization',
        'name',
        'duration'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class);
    }

    public function subState(){
        return $this->belongsTo(SubState::class);
    }

    public function typeTask(){
        return $this->belongsTo(TypeTask::class);
    }

    public function purchaseOperations(){
        return $this->hasMany(PurchaseOperation::class);
    }

    public function pendingAuthorizations(){
        return $this->hasMany(PendingAuthorization::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByTypeTasks($query, array $ids){
        return $query->whereIn('type_task_id', $ids);
    }

    public function scopeBySubStates($query, array $ids){
        return $query->whereIn('sub_state_id', $ids);
    }

    public function scopeByCompany($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }
}
