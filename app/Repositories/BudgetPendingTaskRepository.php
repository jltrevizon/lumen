<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\BudgetPendingTask;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BudgetPendingTaskRepository extends Repository {

    public function __construct()
    {

    }

    public function create($request){
        $user = User::findOrFail(Auth::id());
        $budgetPendingTask = BudgetPendingTask::create($request->all());
        $budgetPendingTask->role_id = $user->role_id;
        $budgetPendingTask->save();
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
                    ->paginate($request->input('per_page'));
    }
}
