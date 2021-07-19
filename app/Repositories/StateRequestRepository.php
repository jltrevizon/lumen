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
            return response()->json(['state_request' => StateRequest::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $state_request = StateRequest::create($request->all());
            $state_request->save();
            return $state_request;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $state_request = StateRequest::findOrFail($id);
            $state_request->update($request->all());
            return response()->json(['state_request' => $state_request], 200);
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
