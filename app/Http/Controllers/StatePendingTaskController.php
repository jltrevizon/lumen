<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatePendingTask;
use App\Repositories\StatePendingTaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StatePendingTaskController extends Controller
{

    public function __construct(StatePendingTaskRepository $statePendingTaskRepository)
    {
        $this->statePendingTaskRepository = $statePendingTaskRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/states-pending-tasks/getall",
    *     tags={"state-pending-tasks"},
    *     summary="Get all state pending tasks",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/StatePendingTask")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(StatePendingTask::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/states-pending-tasks/{id}",
    *     tags={"state-pending-tasks"},
    *     summary="Get state pending task by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/StatePendingTask"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="State Pending Task not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->statePendingTaskRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/states-pending-tasks",
     *     tags={"state-pending-tasks"},
     *     summary="Create state pending task",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createStatePendingTask",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StatePendingTask"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create state pending task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatePendingTask"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->statePendingTaskRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/states-pending-tasks/update/{id}",
     *     tags={"state-pending-tasks"},
     *     summary="Updated purchase state pending task",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated purchase operation object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatePendingTask")
     *     ),
     *     operationId="updateStatePendingTask",
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
     *         @OA\JsonContent(ref="#/components/schemas/StatePendingTask"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="State pending task not found"
     *     ),
     * )
     */
    public function update(Request $request, $id){
        return $this->updateDataResponse($this->statePendingTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/states-pending-tasks/delete/{id}",
     *     summary="Delete state pending task",
     *     tags={"state-pending-tasks"},
     *     operationId="deleteStatePendingTask",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="State pending task not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->statePendingTaskRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
