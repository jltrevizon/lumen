<?php

namespace App\Repositories;

use App\Models\BudgetLine;

class BudgetLineRepository extends Repository {

    public function index($request){
        return BudgetLine::with($this->getWiths($request->with))
                ->filter($request->all())
                ->paginate($request->input('per_page'));
    }

}
