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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Incidence"),
    *    ),
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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/IncidenceType"),
    *    ),
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
     *     path="/incidences/update/{id}",
     *     tags={"incidences"},
     *     summary="Updated incidence",
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
     *             type="string"
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

    public function delete($id){
        return $this->deleteDataResponse($this->incidenceRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
