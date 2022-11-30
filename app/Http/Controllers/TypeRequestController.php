<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeRequest;
use App\Repositories\TransportRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TypeRequestController extends Controller
{

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/type-requests/getall",
    *     tags={"type-requests"},
    *     summary="Get all type requests",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/TypeRequest"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(TypeRequest::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/type-requests/{id}",
    *     tags={"type-requests"},
    *     summary="Get type request by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/TypeRequest"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Type Request not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->transportRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){
        return $this->createDataResponse($this->transportRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/type-requests/update/{id}",
     *     tags={"type-requests"},
     *     summary="Updated type request",
     *     @OA\RequestBody(
     *         description="Updated type request object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeRequest")
     *     ),
     *     operationId="updateTypeRequest",
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
     *         @OA\JsonContent(ref="#/components/schemas/TypeRequest"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Type request not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->transportRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->transportRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
