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

    public function getAll(){
        return $this->getDataResponse(PurchaseOperation::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->purchaseOperationRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'task_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required'
        ]);

        return $this->createDataResponse($this->purchaseOperationRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->purchaseOperationRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->purchaseOperationRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
