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
            return response()->json(['state' => State::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $state = new State();
            $state->name = $request->input('name');
            $state->save();
            return $state;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $state = State::findOrFail($id);
            $state->update($request->all());
            return response()->json(['state' => $state], 200);
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
