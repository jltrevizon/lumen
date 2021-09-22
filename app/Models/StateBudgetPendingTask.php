<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateBudgetPendingTask extends Model
{

    use HasFactory;

    const PENDING = 1;
    const APPROVED = 2;
    const DECLINE = 3;

    public function budgetPendingTasks(){
        return $this->hasMany(BudgetPendingTask::class);
    }
}
