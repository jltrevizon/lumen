<?php

namespace App\Http\Controllers;

use App\Models\DamageImage;
use App\Repositories\DamageImageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DamageImageController extends Controller
{

    public function __construct(DamageImageRepository $damageImageRepository)
    {
        $this->damageImageRepository = $damageImageRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/damage-images",
    *     tags={"damage-images"},
    *     summary="Get all damage image",
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
    *           @OA\Items(ref="#/components/schemas/DamageImage")
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->damageImageRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/damage-images",
     *     tags={"damage-images"},
     *     summary="Create damage image",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createDamageImage",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DamageImage"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create damage image object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DamageImage"),
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
        return $this->createDataResponse($this->damageImageRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/damage-images/{id}",
     *     tags={"damage-images"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     summary="Updated damage image",
     *     @OA\RequestBody(
     *         description="Updated damage image object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DamageImage")
     *     ),
     *     operationId="updateDamageImage",
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
     *         @OA\JsonContent(ref="#/components/schemas/DamageImage"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Damage image not found"
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
        return $this->updateDataResponse($this->damageImageRepository->update($request, $id), Response::HTTP_OK);
    }

}
