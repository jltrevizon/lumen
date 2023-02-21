<?php

namespace App\Http\Controllers;

use App\Models\CampaUser;
use App\Models\User;
use App\Notifications\BudgetPendingTaskNotification;
use App\Repositories\BudgetPendingTaskRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class BudgetPendingTaskController extends Controller
{
    public function __construct(BudgetPendingTaskRepository $budgetPendingTaskRepository)
    {
        $this->budgetPendingTaskRepository = $budgetPendingTaskRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/budget-pending-task",
     *     tags={"budget-pending-tasks"},
     *     summary="Create budget pending task",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createBudgetPendingTask",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BudgetPendingTask"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create operation object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BudgetPendingTask"),
     *     )
     * )
     */

    public function store(Request $request){
        $data = $this->budgetPendingTaskRepository->store($request);
        $ids = CampaUser::where('campa_id', $data->campa_id)
        ->get()
        ->pluck('user_id');
        $send_to = User::whereIn('id', $ids)->get();
        foreach ($send_to as $key => $value) {
           Notification::send($value, new BudgetPendingTaskNotification($data));
        }
        return $this->createDataResponse($data, HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/budget-pending-task/{id}",
     *     tags={"budget-pending-tasks"},
     *     summary="Updated budget pending task",
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         value= @OA\JsonContent(
    *              @OA\Property(
    *                  property="brands",
    *                  type="object",
    *                  ref="#/components/schemas/BudgetPendingTask"
    *              ),
    *          ),
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

    /**
    * @OA\Get(
    *     path="/api/budget-pending-task",
    *     tags={"budget-pending-tasks"},
    *     summary="Get all budget pending tasks",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/BudgetPendingTaskPaginate")
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */


    public function index(Request $request){
        return $this->getDataResponse($this->budgetPendingTaskRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }
}
