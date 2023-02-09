<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidence;
use App\Repositories\IncidenceRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class IncidenceController extends Controller
{

    public function __construct(IncidenceRepository $incidenceRepository)
    {
        $this->incidenceRepository = $incidenceRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/incidences/getall",
    *     tags={"incidences"},
    *     summary="Get all incidences",
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
    *         @OA\JsonContent(ref="#/components/schemas/IncidencePaginate"),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->incidenceRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/incidence-types/getall",
    *     tags={"incidence-types"},
    *     summary="Get all incidence types",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/IncidenceType")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAllTypes(Request $request){
        return $this->getDataResponse($this->incidenceRepository->getAllTypes($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/incidences/{id}",
    *     tags={"incidences"},
    *     summary="Get incidence by ID",
    *    security={
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
    *         @OA\JsonContent(ref="#/components/schemas/Incidence"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Incidence not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->incidenceRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/incidences",
     *     tags={"incidences"},
     *     summary="Create incidence",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createIncidence",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Incidence"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create group task object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Incidence"),
     *     )
     * )
     */

    public function create(Request $request){
        return $this->createDataResponse($this->incidenceRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function createIncidence(Request $request){
        return $this->createDataResponse($this->incidenceRepository->createIncidence($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function resolved($request){
        return $this->updateDataResponse($this->incidenceRepository->resolved($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/incidences/update/{id}",
     *     tags={"incidences"},
     *     summary="Updated incidence",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated incidence object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Incidence")
     *     ),
     *     operationId="updateIncidence",
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
     *         @OA\JsonContent(ref="#/components/schemas/Incidence"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Incidence not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->incidenceRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/incidences/delete/{id}",
     *     summary="Delete incidence",
     *     tags={"incidences"},
     *     operationId="deleteIncidence",
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
     *         description="Incidence not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->incidenceRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
