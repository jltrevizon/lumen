<?php

namespace App\Http\Controllers;

use App\Repositories\DamageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DamageController extends Controller
{

    public function __construct(DamageRepository $damageRepository)
    {
        $this->damageRepository = $damageRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/damages",
    *     tags={"damages"},
    *     summary="Get all damages",
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
    *           @OA\Items(ref="#/components/schemas/Damage")
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
        return $this->getDataResponse($this->damageRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/damages",
     *     tags={"damages"},
     *     summary="Create damage",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createDamage",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Damage"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create damage object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Damage"),
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
        $data = $this->damageRepository->store($request);
        return $this->createDataResponse($data, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/damages/{id}",
     *     tags={"damages"},
     *     summary="Updated damage",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated damage object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Damage")
     *     ),
     *     operationId="updateDamage",
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
     *         @OA\JsonContent(ref="#/components/schemas/Damage"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Damage not found"
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
        return $this->updateDataResponse($this->damageRepository->update($request, $id), Response::HTTP_OK);
    }

}
