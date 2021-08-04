<?php

namespace App\Repositories;

use App\Models\PurchaseOperation;
use Exception;

class PurchaseOperationRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return PurchaseOperation::findOrFail($id);
    }

    public function create($request){
        $purchase_operation = PurchaseOperation::create($request->all());
        $purchase_operation->save();
        return $purchase_operation;
    }

    public function update($request, $id){
        $purchase_operation = PurchaseOperation::findOrFail($id);
        $purchase_operation->update($request->all());
        return $purchase_operation;
    }

    public function delete($id){
            PurchaseOperation::where('id', $id)
                    ->delete();
            return [ 'message' => 'Purchase operation deleted' ];
    }
}
