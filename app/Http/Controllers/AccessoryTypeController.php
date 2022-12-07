<?php

namespace App\Http\Controllers;

use App\Repositories\AccessoryTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccessoryTypeController extends Controller
{

    public function __construct(AccessoryTypeRepository $accessoryTypeRepository)
    {
        $this->accessoryTypeRepository = $accessoryTypeRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/accessory-types",
    *     tags={"accessory-types"},
    *     summary="Get all accessory types",
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
    *           @OA\Items(ref="#/components/schemas/AccessoryType")
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
        return $this->getDataResponse($this->accessoryTypeRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/accessory-types",
     *     tags={"accessory-types"},
     *     summary="Create accessory type",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createAccessoryType",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryType"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create accessory type object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryType"),
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
        return $this->createDataResponse($this->accessoryTypeRepository->store($request), Response::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/api/accessory-types/{id}",
    *     tags={"accesories"},
    *     summary="Get accessory type by ID",
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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/AccessoryType"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Accessory type not found."
    *     )
    * )
    */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getDataResponse($this->accessoryTypeRepository->show($id), Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/accessory-types/{id}",
     *     tags={"accessory-types"},
     *     summary="Updated accessory type",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated accessory type object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryType")
     *     ),
     *     operationId="updateAccessoryType",
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
     *         @OA\JsonContent(ref="#/components/schemas/AccessoryType"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Accessory type not found"
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
        return $this->updateDataResponse($this->accessoryTypeRepository->update($request, $id), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/accessory-types/{id}",
     *     summary="Delete accessory type",
     *     tags={"accessory-types"},
     *     operationId="deleteAccesorType",
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
     *         description="Accessory type not found",
     *     )
     * )
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->deleteDataResponse($this->accessoryTypeRepository->destroy($id), Response::HTTP_OK);
    }
}
