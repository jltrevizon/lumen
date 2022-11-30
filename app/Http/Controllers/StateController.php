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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/State"),
    *    ),
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

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->stateRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/states/update/{id}",
     *     tags={"states"},
     *     summary="Updated state",
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
     *             type="string"
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

    public function delete($id){
        return $this->deleteDataResponse($this->stateRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
