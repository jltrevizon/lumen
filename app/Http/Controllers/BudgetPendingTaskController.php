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

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->budgetPendingTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->budgetPendingTaskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }
}
