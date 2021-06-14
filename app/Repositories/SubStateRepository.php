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
            return response()->json(['sub_state' => SubState::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $sub_state = new SubState();
            $sub_state->state_id = $request->input('state_id');
            $sub_state->name = $request->input('name');
            $sub_state->save();
            return $sub_state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $sub_state = SubState::findOrFail($id);
            $sub_state->update($request->all());
            return response()->json(['sub_state' => $sub_state], 200);
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
