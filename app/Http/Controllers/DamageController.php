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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->damageRepository->index($request), Response::HTTP_OK);
    }

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
