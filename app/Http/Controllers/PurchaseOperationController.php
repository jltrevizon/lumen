<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOperation;
use App\Repositories\PurchaseOperationRepository;

class PurchaseOperationController extends Controller
{

    public function __construct(PurchaseOperationRepository $purchaseOperationRepository)
    {
        $this->purchaseOperationRepository = $purchaseOperationRepository;
    }

    public function getAll(){
        return PurchaseOperation::all();
    }

    public function getById($id){
        return $this->purchaseOperationRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'task_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required'
        ]);

        return $this->purchaseOperationRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->purchaseOperationRepository->update($request);
    }

    public function delete($id){
        return $this->purchaseOperationRepository->delete($id);
    }
}
