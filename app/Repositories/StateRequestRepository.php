<?php

namespace App\Repositories;

use App\Models\StateRequest;
use Exception;

class StateRequestRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return StateRequest::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $state_request = new StateRequest();
            $state_request->name = $request->json()->get('name');
            $state_request->save();
            return $state_request;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $state_request = StateRequest::where('id', $id)
                        ->first();
            $state_request->name = $request->json()->get('name');
            $state_request->updated_at = date('Y-m-d H:i:s');
            $state_request->save();
            return $state_request;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            StateRequest::where('id', $id)
                ->delete();
            return [
                'message' => 'State request deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
