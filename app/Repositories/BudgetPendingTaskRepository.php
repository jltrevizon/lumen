<?php

namespace App\Repositories;

use App\Models\BudgetPendingTask;
use App\Models\StateBudgetPendingTask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BudgetPendingTaskRepository extends Repository {

    public function __construct()
    {

    }

    public function store($request){
        $user = User::with(['campas'])->findOrFail(Auth::id());
        $budgetPendingTask = BudgetPendingTask::create($request->all());
        $budgetPendingTask->campa_id = $user->campas[0]->id ?? null;
        $budgetPendingTask->save();
        return $budgetPendingTask;
    }

    public function update($request, $id){
        $budgetPendingTask = BudgetPendingTask::findOrFail($id);
        $budgetPendingTask->update($request->all());
        if ($request->input('state_budget_pending_task_id') == StateBudgetPendingTask::APPROVED)
            $budgetPendingTask->approved_by = Auth::id();
        if ($request->input('state_budget_pending_task_id') == StateBudgetPendingTask::DECLINE)
            $budgetPendingTask->declined_by = Auth::id();
        $budgetPendingTask->save();
        return ['budget_pending_task' => $budgetPendingTask];
    }

    public function index($request){
        return BudgetPendingTask::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->paginate($request->input('per_page'));
    }
}
