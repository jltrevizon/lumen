<?php

namespace App\Http\Controllers;

use App\Repositories\ColorRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ColorController extends Controller
{

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->colorRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->colorRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/colors/{id}",
     *     tags={"colors"},
     *     summary="Updated color",
     *     @OA\RequestBody(
     *         description="Updated color object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Color")
     *     ),
     *     operationId="updateColor",
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
     *         @OA\JsonContent(ref="#/components/schemas/Color"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Color not found"
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
        return $this->updateDataResponse($this->colorRepository->update($request, $id), Response::HTTP_OK);
    }
}
