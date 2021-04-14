<?php

namespace App\Repositories;

use App\Models\State;

class StateRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return State::where('id', $id)
                    ->first();
    }

    public function create($request){
        $state = new State();
        $state->name = $request->get('name');
        $state->save();
        return $state;
    }

    public function update($request, $id){
        $state = State::where('id', $id)
                    ->first();
        $state->name = $request->get('name');
        $state->updated_at = date('Y-m-d H:i:s');
        $state->save();
        return $state;
    }

    public function delete($id){
        State::where('id', $id)
            ->delete();
        return [
            'message' => 'State deleted'
        ];
    }
}
