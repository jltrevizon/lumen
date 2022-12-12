<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubState;
use App\Repositories\SubStateRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class SubStateController extends Controller
{

    public function __construct(SubStateRepository $subStateRepository)
    {
        $this->subStateRepository = $subStateRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/sub-states/getall",
    *     tags={"sub-states"},
    *     summary="Get all sub states",
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
    *       name="stateIds[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"1","2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/SubStateWithState")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->subStateRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/sub-states/{id}",
    *     tags={"sub-states"},
    *     summary="Get sub state by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/SubState"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Sub State not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->subStateRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/sub-states",
     *     tags={"sub-states"},
     *     summary="Create sub state",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createSubState",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SubState"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create sub state object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SubState"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'state_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->subStateRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/sub-states/update/{id}",
     *     tags={"sub-states"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     summary="Updated sub state",
     *     @OA\RequestBody(
     *         description="Updated sub state object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SubState")
     *     ),
     *     operationId="updateSubState",
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
     *         @OA\JsonContent(ref="#/components/schemas/SubState"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sub state not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->subStateRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/sub-states/delete/{id}",
     *     summary="Delete sub state",
     *     tags={"sub-states"},
     *     operationId="deleteSubState",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *         description="Sub state not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->subStateRepository->update($id), HttpFoundationResponse::HTTP_OK);
    }
}
