<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPendingTask extends Model
{

    use Filterable, HasFactory;

    protected $fillable = [
        'role_id',
        'pending_task_id',
        'state_budget_pending_task_id',
        'url',
        'comment'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function stateBudgetPendingTask(){
        return $this->belongsTo(StateBudgetPendingTask::class);
    }

    public function scopeByPendingTaskIds($query, $ids){
        return $query->whereIn('pending_task_id', $ids);
    }

    public function scopeByStateBudgetPendingTaskIds($query, $ids){
        return $query->whereIn('state_budget_pending_task_id', $ids);
    }

    public function scopeByPlate($query, $plate){
        return $query->whereHas('pendingTask.vehicle', function(Builder $builder) use($plate) {
            return $builder->where('plate','like',"%$plate%");
        });
    }
}
