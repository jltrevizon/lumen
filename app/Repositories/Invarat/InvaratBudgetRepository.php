<?php

namespace App\Repositories\Invarat;

use App\Models\Budget;
use App\Repositories\Repository;

class InvaratBudgetRepository extends Repository {

    public function __construct(
        InvaratBudgetLineRepository $invaratBudgetLineRepository
    )
    {
        $this->invaratBudgetLineRepository = $invaratBudgetLineRepository;
    }

    public function create($request){
        $budget = new Budget();
        $budget->save();
        $this->invaratBudgetLineRepository->create($request->input('budget_lines'), $budget->id);
        return Budget::with(['budgetLines'])
                ->findOrFail($budget->id);
    }

}
