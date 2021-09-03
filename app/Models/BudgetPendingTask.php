<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetPendingTask extends Model
{
    protected $fillable = [
        'pending_task_id',
        'state_budget_pending_task_id',
        'url'
    ];
}
