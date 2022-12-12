<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\VehiclePictureRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehiclePictureController extends Controller
{

    public function __construct(VehiclePictureRepository $vehiclePictureRepository)
    {
        $this->vehiclePictureRepository = $vehiclePictureRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/vehicle-pictures",
     *     tags={"vehicle-pictures"},
     *     summary="Create vehicle picture",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createVehiclePicture",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/VehiclePicture"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create vehicle picture object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VehiclePicture"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'url' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        return $this->getDataResponse($this->vehiclePictureRepository->create($request->all()), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/vehicle-pictures/delete/{id}",
     *     summary="Delete vehicle pictures",
     *     tags={"vehicle-pictures"},
     *     operationId="deleteVehiclePicture",
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
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle picture not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->vehiclePictureRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/vehicle-pictures/delete-pic-by-place",
     *     tags={"vehicle-pictures"},
     *     summary="Delete pictures by place",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="deletePictureByPlace",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Picture deleted"
     *              ),
     *          ),
     *     ),
     *     @OA\RequestBody(
     *         description="Delete pictures by place",
     *         required=true,
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="vehicle_id",
     *                  type="integer",
     *              ),
     *          ),
     *     )
     * )
     */

    public function deletePictureByPlace($request){
        return $this->deleteDataResponse($this->vehiclePictureRepository->deletePictureByPlace($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/vehicle-pictures/by-vehicle",
     *     tags={"vehicle-pictures"},
     *     summary="Get pictures by vehicle",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getPicturesByVehicle",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="vehicle_pictures",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/VehiclePicture")
     *              ),
     *          ),
     *     ),
     *     @OA\RequestBody(
     *         description="Get pictures by vehicle",
     *         required=true,
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="vehicle_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="with[]",
     *                  type="array",
     *                  @OA\Items(type="string"),
     *              ),
     *          )
     *     )
     * )
     */

    public function getPicturesByVehicle(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->vehiclePictureRepository->getPicturesByVehicle($request), HttpFoundationResponse::HTTP_OK);
    }
}
