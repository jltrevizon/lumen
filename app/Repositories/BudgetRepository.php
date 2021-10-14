<?php

namespace App\Repositories;

use App\Models\Budget;

class BudgetRepository extends Repository {

    public function getAll($request){
        return Budget::with($this->getWiths($request->with))
                ->filter($request->all())
                ->paginate($request->input('per_page'));
    }

}
