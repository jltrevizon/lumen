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
    *     path="/api/vehicle-models",
    *     tags={"vehicle-models"},
    *     summary="Get all vehicle models",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/VehicleModel")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->vehicleModelRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/vehicle-models",
     *     tags={"vehicle-models"},
     *     summary="Create vehicle model",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createVehicleModel",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleModel"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create vehicle model object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehicleModel"),
     *     )
     * )
     */

    public function store(Request $request){
        return $this->createDataResponse($this->vehicleModelRepository->store($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/vehicle-models/{id}",
     *     tags={"vehicle-models"},
     *     summary="Updated vehicle model",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated vehicle model object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehicleModel")
     *     ),
     *     operationId="updateVehicleModel",
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
