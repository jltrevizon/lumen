<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campa;
use App\Repositories\CampaRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CampaController extends Controller
{

    public function __construct(CampaRepository $campaRepository)
    {
        $this->campaRepository = $campaRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/campas/getall",
    *     tags={"campas"},
    *     summary="Get all campas",
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
    *           @OA\Items(ref="#/components/schemas/Campa")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(Request $request){
        return $this->getDataResponse($this->campaRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/campas/{id}",
    *     tags={"campas"},
    *     summary="Get campa by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/Campa"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Campa not found."
    *     )
    * )
    */

    public function show(Request $request, $id){
        return $this->getDataResponse($this->campaRepository->show($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/campas",
     *     tags={"campas"},
     *     summary="Create campa",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createCampa",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Campa"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create campa object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Campa"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->campaRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/campas/update/{id}",
     *     tags={"campas"},
     *     summary="Updated campa",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated campa object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Campa")
     *     ),
     *     operationId="updateCampa",
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
     *         @OA\JsonContent(ref="#/components/schemas/Campa"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campa not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->campaRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/campas/delete/{id}",
     *     summary="Delete campa",
     *     tags={"campas"},
     *     operationId="deleteCampa",
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
     *         description="Campa not found",
     *     )
     * )
     */

    public function delete($id){
        Campa::where('id', $id)
            ->delete();

        return [ 'message' => 'Campa deleted' ];
    }
}
