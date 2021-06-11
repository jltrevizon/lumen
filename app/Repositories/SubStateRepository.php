<?php

namespace App\Repositories;

use App\Models\SubState;
use Exception;

class SubStateRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return SubState::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $sub_state = new SubState();
            $sub_state->state_id = $request->get('state_id');
            $sub_state->name = $request->get('name');
            $sub_state->save();
            return $sub_state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $sub_state = SubState::where('id', $id)
                        ->first();
            if(isset($request['state_id'])) $sub_state->state_id = $request->get('state_id');
            if(isset($request['name'])) $sub_state->name = $request->get('name');
            $sub_state->updated_at = date('Y-m-d H:i:s');
            $sub_state->save();
            return $sub_state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            SubState::where('id', $id)
                ->delete();
            return [
                'message' => 'Sub state deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
