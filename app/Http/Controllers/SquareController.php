<?php

namespace App\Http\Controllers;

use App\Repositories\SquareRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SquareController extends Controller
{

    public function __construct(SquareRepository $squareRepository)
    {
        $this->squareRepository = $squareRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->squareRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->squareRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/squares/{id}",
     *     tags={"squares"},
     *     summary="Updated square",
     *     @OA\RequestBody(
     *         description="Updated square object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Square")
     *     ),
     *     operationId="updateSquare",
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
     *         @OA\JsonContent(ref="#/components/schemas/Square"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Square not found"
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
        return $this->updateDataResponse($this->squareRepository->update($request, $id), Response::HTTP_OK);
    }
}
