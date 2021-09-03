<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\BudgetPendingTask;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BudgetPendingTaskRepository extends Repository {

    public function __construct()
    {

    }

    public function create($request){
        $budgetPendingTask = BudgetPendingTask::create($request->all());
        return $budgetPendingTask;
    }
}
