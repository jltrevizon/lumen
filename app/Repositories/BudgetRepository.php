<?php

namespace App\Repositories;

use App\Models\Accessory;
use App\Models\Budget;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BudgetRepository extends Repository {

    public function getAll($request){
        return Budget::with($this->getWiths($request->with))
                ->filter($request->all())
                ->paginate($request->input('per_page'));
    }

}
