<?php

namespace App\Http\Controllers;

use App\Repositories\AccessoryVehicleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessoryVehicleController extends Controller
{

    public function __construct(AccessoryVehicleRepository $accessoryVehicleRepository)
    {
        $this->accessoryVehicleRepository = $accessoryVehicleRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/accessory-vehicle",
    *     tags={"accessory-vehicles"},
    *     summary="Get all accessory vehicles",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/AccessoryVehicle")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->accessoryVehicleRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/accessory-vehicle",
     *     tags={"accessory-vehicle"},
     *     summary="Create accessory vehicle",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createAccessoryVehicle",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryVehicle"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create accessory vehicle object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryVehicle"),
     *     )
     * )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->accessoryVehicleRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/accessory-vehicle/delete",
     *     tags={"accessory-vehicle"},
     *     summary="Destroy accessory vehicle",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="destroyAccessoryVehicle",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleWithAccessories"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create accessory vehicle object",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="vehicle_id",
     *                         type="integer",
     *                     ),
     *                     @OA\Property(
     *                         property="accesories",
     *                         type="array",
     *                         @OA\Items(ref="#/components/schemas/Accessory")
     *                     ),
     *          ),
     *     )
     * )
     */

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->createDataResponse($this->accessoryVehicleRepository->delete($request), Response::HTTP_CREATED);
    }
}
