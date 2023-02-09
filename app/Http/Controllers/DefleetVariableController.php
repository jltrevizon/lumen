<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DefleetVariableRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DefleetVariableController extends Controller
{

    public function __construct(DefleetVariableRepository $defleetVariableRepository)
    {
        $this->defleetVariablesRepository = $defleetVariableRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/defleet-variables/getall",
    *     tags={"defleet-variables"},
    *     summary="Get all defleet vairables",
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
    *         value= @OA\JsonContent(ref="#/components/schemas/DefleetVariablePaginate")
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->defleetVariablesRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/defleet-variables",
    *     tags={"defleet-variables"},
    *     summary="Get defleet vairables",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/DefleetVariable"),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getVariables(Request $request){

        return $this->getDataResponse($this->defleetVariablesRepository->getVariables($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/defleet-variables",
     *     tags={"defleet-variables"},
     *     summary="Create defleet variable",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createDefleetVariable",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DefleetVariable"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create defleet variable object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DefleetVariable"),
     *     )
     * )
     */

    public function createVariables(Request $request){

        $this->validate($request, [
            'kms' => 'required|integer',
            'years' => 'required|integer'
        ]);

        return $this->createDataResponse($this->defleetVariablesRepository->createVariables($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/defleet-variables",
     *     tags={"defleet-variables"},
     *     summary="Updated variable",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated defleet variable object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DefleetVariable")
     *     ),
     *     operationId="updateDefleetVariable",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DefleetVariable"),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="",
     *     ),
     * )
     */

    public function updateVariables(Request $request){
        return $this->updateDataResponse($this->defleetVariablesRepository->updateVariables($request), HttpFoundationResponse::HTTP_OK);
    }
}
