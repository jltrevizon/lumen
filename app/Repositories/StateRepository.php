<?php

namespace App\Repositories;

use App\Models\State;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class StateRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return State::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $state = new State();
            $state->name = $request->get('name');
            $state->save();
            return $state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $state = State::where('id', $id)
                        ->first();
            $state->name = $request->get('name');
            $state->updated_at = date('Y-m-d H:i:s');
            $state->save();
            return $state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            State::where('id', $id)
                ->delete();
            return [
                'message' => 'State deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
