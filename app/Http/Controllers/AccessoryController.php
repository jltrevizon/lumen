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
    * @OA\Get(
    *     path="/api/accessories",
    *     tags={"accessories"},
    *     summary="Get all accessories",
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
    *           example={"vehicles","accessoryType"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/Accessory")
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
        return $this->getDataResponse($this->accessoryRepository->index($request), Response::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/accessories/{id}",
    *     tags={"accessories"},
    *     summary="Get accessory by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
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
    *         @OA\JsonContent(ref="#/components/schemas/Accessory"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Accessory not found."
    *     )
    * )
    */

    public function show(Request $request, $id)
    {
        return $this->getDataResponse($this->accessoryRepository->show($request, $id));
    }

    /**
     * @OA\Post(
     *     path="/api/accessories",
     *     tags={"accessories"},
     *     summary="Create accessory",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createAccessory",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Accessory"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create accessory object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Accessory"),
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
        return $this->createDataResponse($this->accessoryRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/accessories/{id}",
     *     tags={"accessories"},
     *     summary="Updated accessory",
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *             type="integer"
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

    /**
     * @OA\Delete(
     *     path="/api/accessories/{id}",
     *     summary="Delete accessory",
     *     tags={"accessories"},
     *     operationId="deleteAccessory",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *         description="Accessory not found",
     *     ),
     * ),
     */

    public function destroy($id)
    {
        return $this->deleteDataResponse($this->accessoryRepository->destroy($id), Response::HTTP_OK);
    }

}
