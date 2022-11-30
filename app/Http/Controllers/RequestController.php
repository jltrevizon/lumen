<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestVehicle;
use App\Repositories\RequestRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RequestController extends Controller
{
    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/requests/getall",
    *     tags={"requests"},
    *     summary="Get all requests",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Request"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(RequestVehicle::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/requests/{id}",
    *     tags={"requests"},
    *     summary="Get request by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/Request"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Request not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse(RequestVehicle::findOrFail($id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [ 'message' => 'Request deleted' ];
    }
}
