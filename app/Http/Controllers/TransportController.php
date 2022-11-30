<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;
use App\Repositories\TransportRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TransportController extends Controller
{

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/transports/getall",
    *     tags={"transports"},
    *     summary="Get all transports",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Transport"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(Transport::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/transports/{id}",
    *     tags={"transports"},
    *     summary="Get transport by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/Transport"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Transport not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->transportRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->transportRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/transports/update/{id}",
     *     tags={"transports"},
     *     summary="Updated transport",
     *     @OA\RequestBody(
     *         description="Updated transport object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Transport")
     *     ),
     *     operationId="updateTransport",
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
     *         @OA\JsonContent(ref="#/components/schemas/Transport"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transport not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->transportRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->transportRepository->update($id), HttpFoundationResponse::HTTP_OK);
    }
}
