<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOperation;

class PurchaseOperationController extends Controller
{
    public function getAll(){
        return PurchaseOperation::all();
    }

    public function getById($id){
        return PurchaseOperation::where('id', $id)
                        ->first();
    }

    public function create(Request $request){
        $purchase_operation = new PurchaseOperation();
        $purchase_operation->task_id = $request->get('task_id');
        $purchase_operation->name = $request->get('name');
        $purchase_operation->price = $request->get('price');
        $purchase_operation->save();
        return $purchase_operation;
    }

    public function update(Request $request, $id){
        $purchase_operation = PurchaseOperation::where('id', $id)
                            ->first();
        if(isset($request['task_id'])) $purchase_operation->task_id = $request->get('task_id');
        if(isset($request['name'])) $purchase_operation->name = $request->get('name');
        if(isset($request['price'])) $purchase_operation->price = $request->get('price');
        $purchase_operation->updated_at = date('Y-m-d H:i:s');
        $purchase_operation->save();
        return $purchase_operation;
    }

    public function delete($id){
        PurchaseOperation::where('id', $id)
                ->delete();
        return [
            'message' => 'Purchase operation deleted'
        ];
    }
}
