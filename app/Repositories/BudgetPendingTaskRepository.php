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

    public function update($request, $id){
        $budgetPendingTask = BudgetPendingTask::findOrFail($id);
        $budgetPendingTask->update($request->all());
        return ['budget_pending_task' => $budgetPendingTask];
    }

    public function getAll($request){
        return BudgetPendingTask::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->get();
    }
}
