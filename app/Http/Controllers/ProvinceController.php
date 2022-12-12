<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Repositories\ProvinceRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProvinceController extends Controller
{

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/provinces/getall",
    *     tags={"provinces"},
    *     summary="Get all provinces",
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
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/ProvincePaginate"),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->provinceRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/provinces/{id}",
    *     tags={"provinces"},
    *     summary="Get province by ID",
    *    security={
    *           {"bearerAuth": {}}
    *      },
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
    *         @OA\JsonContent(ref="#/components/schemas/Province"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Province not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->provinceRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/provinces",
     *     tags={"provinces"},
     *     summary="Create provinces",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createProvince",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Province"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create province object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Province"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer',
            'province_code' => 'required|string',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->provinceRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/provinces/update/{id}",
     *     tags={"provinces"},
     *     summary="Updated province",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated province object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Province")
     *     ),
     *     operationId="updateProvince",
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
     *         @OA\JsonContent(ref="#/components/schemas/Province"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Province not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->provinceRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/provinces/delete/{id}",
     *     summary="Delete province",
     *     tags={"provinces"},
     *     operationId="deleteProvince",
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
     *         description="Province not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->provinceRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
