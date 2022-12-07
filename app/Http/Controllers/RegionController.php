<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Repositories\RegionRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RegionController extends Controller
{

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/regions/getall",
    *     tags={"regions"},
    *     summary="Get all regions",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/Region")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(Region::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/regions/{id}",
    *     tags={"regions"},
    *     summary="Get region by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
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
    *         @OA\JsonContent(ref="#/components/schemas/Region"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Region not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->regionRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/regions",
     *     tags={"regions"},
     *     summary="Create regions",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createRegion",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Region"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create region object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Region"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->regionRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/regions/update/{id}",
     *     tags={"regions"},
     *     summary="Updated region",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated region object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Region")
     *     ),
     *     operationId="updateRegion",
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
     *         @OA\JsonContent(ref="#/components/schemas/Region"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Region not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->regionRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/regions/delete/{id}",
     *     summary="Delete region",
     *     tags={"regions"},
     *     operationId="deleteRegion",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
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
     *         description="Region not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->regionRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
