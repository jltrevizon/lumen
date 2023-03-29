<?php

namespace App\Http\Controllers;

use App\Models\CampaUser;
use App\Models\User;
use App\Notifications\DamageNotification;
use App\Repositories\DamageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Notification;

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
    *     @OA\Parameter(
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="notNullDamageTypeId",
    *       in="query",
    *       description="not null damage type id",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="vehicleCampaIds[]",
    *       in="query",
    *       description="A list of vehicle campa IDs",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={1,2},
    *           @OA\Items(type="integer")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/DamagePaginate")
    *     ),
    *     @OA\Response(
    *         response=500,
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
        $ids = CampaUser::where('campa_id', $data->vehicle->campa_id)
            ->get()
            ->pluck('user_id');
        $send_to = User::whereIn('id', $ids)->get();
        foreach ($send_to as $key => $value) {
            Notification::send($value, new DamageNotification([
                'data' => $data,
                'title' => 'Se ha subido una incidencia al vehiculo ' . $data->vehicle->plate
            ]));
        }
        return $this->createDataResponse($data, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/damages/{id}",
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
     *             type="integer"
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
