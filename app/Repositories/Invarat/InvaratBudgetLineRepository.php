<?php

namespace App\Repositories\Invarat;

use App\Models\Budget;
use App\Models\BudgetLine;
use App\Repositories\Repository;
use App\Repositories\TaxRepository;

class InvaratBudgetLineRepository extends Repository {

    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function create($lines, $budgetId){

        foreach($lines as $line){
            $tax = $this->taxRepository->byId($line['tax_id']);
            $budgetLine = new BudgetLine();
            $budgetLine->budget_id = $budgetId;
            $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
            $budgetLine->price = $line['price'];
            $budgetLine->amount = $line['amount'];
            $budgetLine->tax_id = $line['tax_id'];
            $budgetLine->name = $line['name'];
            $budgetLine->sub_total = round($budgetLine->price * $budgetLine->amount, 2);
            $budgetLine->tax = (($tax['value'] / 100) * $budgetLine->sub_total);
            $budgetLine->total = $budgetLine->sub_total + $budgetLine->tax;
            $budgetLine->save();
        }

    }

    public function update($lines, $budgetId){
        foreach($lines as $line){
            if($line['budget_line_id'] != null){
                $tax = $this->taxRepository->byId($line['tax_id']);
                $budgetLine = BudgetLine::findOrFail($line['budget_line_id']);
                $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
                $budgetLine->price = $line['price'];
                $budgetLine->amount = $line['amount'];
                $budgetLine->tax_id = $line['tax_id'];
                $budgetLine->name = $line['name'];
                $budgetLine->sub_total = round($budgetLine->price * $budgetLine->amount, 2);
                $budgetLine->tax = (($tax['value'] / 100) * $budgetLine->sub_total);
                $budgetLine->total = $budgetLine->sub_total + $budgetLine->tax;
                $budgetLine->save();
            } else {
                $this->createOneBudgetLine($line, $budgetId);
            }
        }

    }

    public function createOneBudgetLine($line, $budgetId){
        $tax = $this->taxRepository->byId($line['tax_id']);
        $budgetLine = new BudgetLine();
        $budgetLine->budget_id = $budgetId;
        $budgetLine->type_budget_line_id = $line['type_budget_line_id'];
        $budgetLine->price = $line['price'];
        $budgetLine->amount = $line['amount'];
        $budgetLine->tax_id = $line['tax_id'];
        $budgetLine->name = $line['name'];
        $budgetLine->sub_total = round($budgetLine->price * $budgetLine->amount, 2);
        $budgetLine->tax = (($tax['value'] / 100) * $budgetLine->sub_total);
        $budgetLine->total = $budgetLine->sub_total + $budgetLine->tax;
        $budgetLine->save();
    }

}
