<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeTask;
use App\Repositories\TypeTaskRepository;

class TypeTaskController extends Controller
{

    public function __construct(TypeTaskRepository $typeTaskRepository)
    {
        $this->typeTaskRepository = $typeTaskRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/type-tasks/getall",
    *     tags={"type-tasks"},
    *     summary="Get all type tasks",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/TypeTask"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return TypeTask::all();
    }

    /**
    * @OA\Get(
    *     path="/api/type-tasks/{id}",
    *     tags={"type-tasks"},
    *     summary="Get type task by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/TypeTask"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Type Task not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->typeTaskRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->typeTaskRepository->create($request);
    }

    /**
     * @OA\Put(
     *     path="/type-tasks/update/{id}",
     *     tags={"type-tasks"},
     *     summary="Updated type task",
     *     @OA\RequestBody(
     *         description="Updated type task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeTask")
     *     ),
     *     operationId="updateTypeTask",
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
     *         @OA\JsonContent(ref="#/components/schemas/TypeTask"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Type task not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->typeTaskRepository->update($request, $id);
    }

    public function delete($id){
        return $this->typeTaskRepository->delete($id);
    }
}
