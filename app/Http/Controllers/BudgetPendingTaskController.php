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

    public function store(Request $request){
        return $this->createDataResponse($this->budgetPendingTaskRepository->store($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/budget-pending-task/{id}",
     *     tags={"budget-pending-task"},
     *     summary="Updated budget pending task",
     *     @OA\RequestBody(
     *         description="Updated budget pending task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BudgetPendingTask")
     *     ),
     *     operationId="updateBudgetPendingTask",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BudgetPendingTask"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Operation not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->budgetPendingTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function index(Request $request){
        return $this->getDataResponse($this->budgetPendingTaskRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }
}
