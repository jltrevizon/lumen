<?php

namespace App\Http\Controllers;

use App\Repositories\StatusDamageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusDamageController extends Controller
{

    public function __construct(StatusDamageRepository $statusDamageRepository)
    {
        $this->statusDamageRepository = $statusDamageRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/status-damages",
    *     tags={"status-damages"},
    *     summary="Get all status damages",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/StatusDamage")
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
    public function index()
    {
        return $this->getDataResponse($this->statusDamageRepository->index(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/status-damages",
     *     tags={"status-damages"},
     *     summary="Create status damage",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createStatusDamage",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StatusDamage"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create status damage object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatusDamage"),
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
        return $this->createDataResponse($this->statusDamageRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/status-damages/{id}",
     *     tags={"status-damages"},
     *     summary="Updated status damage",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated status damage object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatusDamage")
     *     ),
     *     operationId="updateStatusDamage",
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
     *         @OA\JsonContent(ref="#/components/schemas/StatusDamage"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Status damage not found"
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
        return $this->updateDataResponse($this->statusDamageRepository->update($request, $id), Response::HTTP_OK);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
