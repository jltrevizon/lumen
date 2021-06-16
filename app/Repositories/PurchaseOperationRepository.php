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
            $purchase_operation = new PurchaseOperation();
            $purchase_operation->task_id = $request->get('task_id');
            $purchase_operation->name = $request->get('name');
            $purchase_operation->price = $request->get('price');
            $purchase_operation->save();
            return $purchase_operation;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $purchase_operation = PurchaseOperation::where('id', $id)
                                ->first();
            if(isset($request['task_id'])) $purchase_operation->task_id = $request->get('task_id');
            if(isset($request['name'])) $purchase_operation->name = $request->get('name');
            if(isset($request['price'])) $purchase_operation->price = $request->get('price');
            $purchase_operation->updated_at = date('Y-m-d H:i:s');
            $purchase_operation->save();
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
