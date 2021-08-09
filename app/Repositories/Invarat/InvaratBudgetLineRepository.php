<?php

namespace App\Repositories\Invarat;

use App\Models\Budget;
use App\Models\BudgetLine;
use App\Repositories\Repository;

class InvaratBudgetLineRepository extends Repository {

    public function create($lines, $budgetId){

        foreach($lines as $line){
            $budgetLine = new BudgetLine();
            $budgetLine->budget_id = $budgetId;
            $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
            $budgetLine->tax_id = $line['tax_id'];
            $budgetLine->name = $line['name'];
            $budgetLine->sub_total = $line['sub_total'];
            $budgetLine->tax = $line['tax'];
            $budgetLine->total = $line['total'];
            $budgetLine->save();
        }

    }

    public function update($lines, $budgetId){

        foreach($lines as $line){
            if($line['budget_line_id'] != null){
                $budgetLine = BudgetLine::findOrFail($line['budget_line_id']);
                $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
                $budgetLine->tax_id = $line['tax_id'];
                $budgetLine->name = $line['name'];
                $budgetLine->sub_total = $line['sub_total'];
                $budgetLine->tax = $line['tax'];
                $budgetLine->total = $line['total'];
                $budgetLine->save();
            } else {
                $this->createOneBudgetLine($line, $budgetId);
            }
        }

    }

    public function createOneBudgetLine($line, $budgetId){
        $budgetLine = new BudgetLine();
        $budgetLine->budget_id = $budgetId;
        $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
        $budgetLine->tax_id = $line['tax_id'];
        $budgetLine->name = $line['name'];
        $budgetLine->sub_total = $line['sub_total'];
        $budgetLine->tax = $line['tax'];
        $budgetLine->total = $line['total'];
        $budgetLine->save();
    }

}
