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
