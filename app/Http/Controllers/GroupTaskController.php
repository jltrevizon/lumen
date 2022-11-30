<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTask;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Repositories\GroupTaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class GroupTaskController extends Controller
{

    public function __construct(GroupTaskRepository $groupTaskRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/grouptasks/getall",
    *     tags={"group tasks"},
    *     summary="Get all group tasks",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/GroupTask"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->groupTaskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/grouptasks/{id}",
    *     tags={"group-tasks"},
    *     summary="Get group task by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/GroupTask"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Group Task not found."
    *     )
    * )
    */

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->groupTaskRepository->getById($request, $id),HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->createDataResponse($this->groupTaskRepository->create($request->all()), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/grouptasks/update/{id}",
     *     tags={"group-tasks"},
     *     summary="Updated group task",
     *     @OA\RequestBody(
     *         description="Updated group task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GroupTask")
     *     ),
     *     operationId="updateGroupTask",
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
     *         @OA\JsonContent(ref="#/components/schemas/GroupTask"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Group Task not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->groupTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        GroupTask::where('id', $id)
            ->delete();

        return [ 'message' => 'Group task deleted' ];
    }

    public function approvedGroupTaskToAvailable(Request $request){
        $data = $this->groupTaskRepository->approvedGroupTaskToAvailable($request);
        if (!is_null($data)) {
            return $this->updateDataResponse($data, HttpFoundationResponse::HTTP_OK);
        } else {
            return $this->updateDataResponse($data, HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function declineGroupTask(Request $request){
        return $this->updateDataResponse($this->groupTaskRepository->declineGroupTask($request), HttpFoundationResponse::HTTP_OK);
    }

}
