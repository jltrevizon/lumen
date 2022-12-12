<?php

namespace App\Http\Controllers;

use App\Repositories\StreetRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StreetController extends Controller
{

    public function __construct(StreetRepository $streetRepository)
    {
        $this->streetRepository = $streetRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/streets",
    *     tags={"streets"},
    *     summary="Get all streets",
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
    *     @OA\Parameter(
    *       name="campaIds[]",
    *       in="query",
    *       description="A list of campaIDs",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={1,2},
    *           @OA\Items(type="integer")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/StreetWithZone")
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
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->streetRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/streets",
     *     tags={"streets"},
     *     summary="Create street",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createStreet",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Street"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create street object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Street"),
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
        return $this->createDataResponse($this->streetRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/streets/{id}",
     *     tags={"streets"},
     *     summary="Updated street",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated street object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Street")
     *     ),
     *     operationId="updateStreet",
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
     *         @OA\JsonContent(ref="#/components/schemas/Street"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Street not found"
     *     ),
     * )
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->updateDataResponse($this->streetRepository->update($request, $id), Response::HTTP_OK);
    }

}
