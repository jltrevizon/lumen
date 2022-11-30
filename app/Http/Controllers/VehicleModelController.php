<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Repositories\VehicleModelRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehicleModelController extends Controller
{
    public function __construct(VehicleModelRepository $vehicleModelRepository)
    {
        $this->vehicleModelRepository = $vehicleModelRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/vehicle-models/getall",
    *     tags={"vehicle-models"},
    *     summary="Get all type vehicle models",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/VehicleModel"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse($this->vehicleModelRepository->getAll(), HttpFoundationResponse::HTTP_OK);
    }

    public function store(Request $request){
        return $this->createDataResponse($this->vehicleModelRepository->store($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/vehicle-models/{id}",
     *     tags={"vehicle-models"},
     *     summary="Updated vehicle model",
     *     @OA\RequestBody(
     *         description="Updated vehicle model object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehicleModel")
     *     ),
     *     operationId="updateRole",
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
     *         @OA\JsonContent(ref="#/components/schemas/VehicleModel"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle Model not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->vehicleModelRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
