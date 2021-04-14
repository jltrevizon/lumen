<?php

namespace App\Repositories;

use App\Models\SubState;

class SubStateRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return SubState::where('id', $id)
                    ->first();
    }

    public function create($request){
        $sub_state = new SubState();
        $sub_state->state_id = $request->get('state_id');
        $sub_state->name = $request->get('name');
        $sub_state->save();
        return $sub_state;
    }

    public function update($request, $id){
        $sub_state = SubState::where('id', $id)
                    ->first();
        if(isset($request['state_id'])) $sub_state->state_id = $request->get('state_id');
        if(isset($request['name'])) $sub_state->name = $request->get('name');
        $sub_state->updated_at = date('Y-m-d H:i:s');
        $sub_state->save();
        return $sub_state;
    }

    public function delete($id){
        SubState::where('id', $id)
            ->delete();
        return [
            'message' => 'Sub state deleted'
        ];
    }

}
