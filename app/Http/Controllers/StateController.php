<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Repositories\StateRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StateController extends Controller
{

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/states/getall",
    *     tags={"states"},
    *     summary="Get all states",
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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/State")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->stateRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/states/{id}",
    *     tags={"states"},
    *     summary="Get state by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/State"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="State not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->stateRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function getStatesWithVehicles(Request $request){
        return $this->getDataResponse($this->stateRepository->getStatesWithVehicles($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getStatesWithVehiclesCampa(Request $request){
        return $this->getDataResponse($this->stateRepository->getStatesWithVehiclesCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/states",
     *     tags={"states"},
     *     summary="Create state",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createState",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/State"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create state object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/State"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->stateRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/states/update/{id}",
     *     tags={"states"},
     *     summary="Updated state",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated purchase state object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/State")
     *     ),
     *     operationId="updateState",
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
     *         @OA\JsonContent(ref="#/components/schemas/State"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="State not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->stateRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/states/delete/{id}",
     *     summary="Delete state",
     *     tags={"states"},
     *     operationId="deleteState",
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
     *         description="State not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->stateRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
