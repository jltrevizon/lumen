<?php

namespace App\Http\Controllers;

use App\Repositories\HistoryLocationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HistoryLocationController extends Controller
{

    public function __construct(HistoryLocationRepository $historyLocationRepository)
    {
        $this->historyLocationRepository = $historyLocationRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/history-locations",
    *     tags={"history-locations"},
    *     summary="Get all history-locations",
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
    *           example=15,
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
    *       name="campaIds[]",
    *       in="query",
    *       description="A list of campaIDs",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={1,2},
    *           @OA\Items(type="integer")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="vehicleCampaIds[]",
    *       in="query",
    *       description="A list of campaIDs",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={1,2},
    *           @OA\Items(type="integer")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="vehiclePlate",
    *       in="query",
    *       description="Plate",
    *       required=false,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="states[]",
    *       in="query",
    *       description="A list of states",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={1,2},
    *           @OA\Items(type="integer")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="whereHasVehicle",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=0,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/HistoryLocationPaginate")
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
        return $this->getDataResponse($this->historyLocationRepository->index($request), Response::HTTP_OK);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
