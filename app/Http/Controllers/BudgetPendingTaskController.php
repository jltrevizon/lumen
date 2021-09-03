<?php

namespace App\Http\Controllers;

use App\Repositories\BudgetPendingTaskRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class BudgetPendingTaskController extends Controller
{
    public function __construct(BudgetPendingTaskRepository $budgetPendingTaskRepository)
    {
        $this->budgetPendingTaskRepository = $budgetPendingTaskRepository;
    }

    public function create(Request $request){
        return $this->createDataResponse($this->budgetPendingTaskRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }
}
