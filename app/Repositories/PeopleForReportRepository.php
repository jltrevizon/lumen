<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\BudgetPendingTask;
use App\Models\PeopleForReport;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class PeopleForReportRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return PeopleForReport::with($request->with)
            ->filter($request->all())
            ->paginate();
    }
}
