<?php

namespace App\Http\Controllers;

use App\Repositories\AccessoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessoryController extends Controller
{

    public function __construct(AccessoryRepository $accessoryRepository)
    {
        $this->accessoryRepository = $accessoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->accessoryRepository->index($request), Response::HTTP_OK);
    }

    public function show(Request $request, $id)
    {
        return $this->getDataResponse($this->accessoryRepository->show($request, $id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->accessoryRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/accessories/{id}",
     *     tags={"accessories"},
     *     summary="Updated accessory",
     *     @OA\RequestBody(
     *         description="Updated accessory object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Accessory")
     *     ),
     *     operationId="updateAccessory",
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
     *         @OA\JsonContent(ref="#/components/schemas/Accessory"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Accessory not found"
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
        return $this->updateDataResponse($this->accessoryRepository->update($request, $id), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        return $this->deleteDataResponse($this->accessoryRepository->delete($id), Response::HTTP_OK);
    }

}
