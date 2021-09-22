<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPendingTask extends Model
{

    use Filterable, HasFactory;

    protected $fillable = [
        'pending_task_id',
        'state_budget_pending_task_id',
        'url'
    ];

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
}
