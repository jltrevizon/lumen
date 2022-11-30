<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOperation;
use App\Repositories\PurchaseOperationRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PurchaseOperationController extends Controller
{

    public function __construct(PurchaseOperationRepository $purchaseOperationRepository)
    {
        $this->purchaseOperationRepository = $purchaseOperationRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/purchase-operations/getall",
    *     tags={"purchase-operations"},
    *     summary="Get all purchase operatons",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/PurchaseOperation"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(PurchaseOperation::all(), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/purchase-operations/{id}",
    *     tags={"purchase-operations"},
    *     summary="Get purchase operation by ID",
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
    *         @OA\JsonContent(ref="#/components/schemas/PurchaseOperation"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Purchase Operation not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->purchaseOperationRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'task_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required'
        ]);

        return $this->createDataResponse($this->purchaseOperationRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/purchase-operations/update/{id}",
     *     tags={"purchase-operations"},
     *     summary="Updated purchase operation",
     *     @OA\RequestBody(
     *         description="Updated purchase operation object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PurchaseOperation")
     *     ),
     *     operationId="updatePurchaseOperation",
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
     *         @OA\JsonContent(ref="#/components/schemas/PurchaseOperation"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Purchase operation not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->purchaseOperationRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->purchaseOperationRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
