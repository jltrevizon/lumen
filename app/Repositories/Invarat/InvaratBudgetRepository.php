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
        $budget->vehicle_id = $request->input('vehicle_id');
        $budget->order_id = $request->input('order_id');
        $budget->save();
        $this->invaratBudgetLineRepository->create($request->input('budget_lines'), $budget->id);
        return $this->calculateTotals($budget->id);
    }

    public function calculateTotals($budgetId){
        $budget = Budget::with(['budgetLines'])
                    ->findOrFail($budgetId);
        $subTotal = 0;
        $tax = 0;
        $total = 0;
        foreach($budget['budgetLines'] as $line){
            $subTotal += $line['sub_total'];
            $tax += $line['tax'];
            $total += $line['total'];
        }
        $budget->sub_total = $subTotal;
        $budget->tax = $tax;
        $budget->total = $total;
        $budget->save();
        return Budget::with(['budgetLines','vehicle'])
            ->findOrFail($budgetId);
    }

    public function update($request){
        $budget = Budget::findOrFail($request->input('budget_id'));
        $this->invaratBudgetLineRepository->update($request->input('budget_lines'), $budget->id);
        return $this->calculateTotals($budget->id);
    }

}
