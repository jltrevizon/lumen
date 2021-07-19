<?php

namespace App\Repositories;

use App\Models\PurchaseOperation;
use Exception;

class PurchaseOperationRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return PurchaseOperation::where('id', $id)
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $purchase_operation = PurchaseOperation::create($request->all());
            $purchase_operation->save();
            return $purchase_operation;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $purchase_operation = PurchaseOperation::findOrFail($id);
            $purchase_operation->update($request->all());
            return $purchase_operation;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            PurchaseOperation::where('id', $id)
                    ->delete();
            return [
                'message' => 'Purchase operation deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
