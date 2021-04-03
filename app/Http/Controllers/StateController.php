<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function getAll(){
        return State::all();
    }

    public function getById($id){
        return State::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $state = new State();
        $state->name = $request->get('name');
        $state->save();
        return $state;
    }

    public function update(Request $request, $id){
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
