<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateRequest;
use App\Repositories\StateRequestRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StateRequestController extends Controller
{

    public function __construct(StateRequestRepository $stateRequestRepository)
    {
        $this->stateRequestRepository = $stateRequestRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/state-requests/getall",
    *     tags={"state-requests"},
    *     summary="Get all state requests",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/StateRequest")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(StateRequest::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/state-requests/{id}",
    *     tags={"state-requests"},
    *     summary="Get state request by ID",
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
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/StateRequest"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="State Request not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->stateRequestRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/state-requests",
     *     tags={"state-requests"},
     *     summary="Create state request",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createStateRequest",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StateRequest"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create state request object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StateRequest"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->stateRequestRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/state-requests/update/{id}",
     *     tags={"state-requests"},
     *     summary="Updated state request",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Updated state request object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StateRequest")
     *     ),
     *     operationId="updateStateRequest",
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
     *         @OA\JsonContent(ref="#/components/schemas/StateRequest"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="State request not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->stateRequestRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/state-requests/delete/{id}",
     *     summary="Delete state request",
     *     tags={"state-requests"},
     *     operationId="deleteStateRequest",
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
     *         description="State request not found",
     *     )
     * )
     */

    public function delete($id){
        return $this->deleteDataResponse($this->stateRequestRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
