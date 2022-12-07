<?php

namespace App\Http\Controllers;

use App\Repositories\VehicleExitRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehicleExitController extends Controller
{
    public function __construct(VehicleExitRepository $vehicleExitRepository)
    {
        $this->vehicleExitRepository = $vehicleExitRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/vehicle-exits/getall",
    *     tags={"vehicle-exits"},
    *     summary="Get all type vehicle exits",
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
    *           @OA\Items(ref="#/components/schemas/VehicleExit")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->vehicleExitRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/vehicle-exits/{id}",
    *     tags={"vehicle-exits"},
    *     summary="Get vehicle exit by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/VehicleExit"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Vehicle Exit not found."
    *     )
    * )
    */

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->vehicleExitRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/vehicle-exits",
     *     tags={"vehicle-exits"},
     *     summary="Create vehicle exit",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createVehicleExit",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleExit"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create vehicle exit object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehicleExit"),
     *     )
     * )
     */

    public function create(Request $request){
        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'pending_task_id' => 'required|integer',
            'delivery_by' => 'required|string',
            'delivery_to' => 'required|string',
            'name_place' => 'required|string'
        ]);
        return $this->createDataResponse($this->vehicleExitRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/vehicle-exits/{id}",
     *     tags={"vehicle-exits"},
     *     summary="Updated vehicle exit model",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated vehicle exit object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehicleExit")
     *     ),
     *     operationId="updateVehicleExit",
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
     *         @OA\JsonContent(ref="#/components/schemas/VehicleExit"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle Exit not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->vehicleExitRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

}
