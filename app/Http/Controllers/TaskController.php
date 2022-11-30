<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TaskController extends Controller
{

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/tasks/getall",
    *     tags={"tasks"},
    *     summary="Get all tasks",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Task"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->taskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/tasks/{id}",
    *     tags={"tasks"},
    *     summary="Get task by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/Task"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Task not found."
    *     )
    * )
    */

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->taskRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'sub_state_id' => 'required|integer',
            'type_task_id' => 'required|integer',
            'name' => 'required|string',
            'duration' => 'required|integer',
        ]);

        return $this->createDataResponse($this->taskRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/tasks/update/{id}",
     *     tags={"tasks"},
     *     summary="Updated task",
     *     @OA\RequestBody(
     *         description="Updated task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     operationId="updateTask",
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
     *         @OA\JsonContent(ref="#/components/schemas/Task"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->taskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->taskRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

}
