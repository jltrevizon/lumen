<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateRequest;

class StateRequestController extends Controller
{
    public function getAll(){
        return StateRequest::all();
    }

    public function getById($id){
        return StateRequest::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $state_request = new StateRequest();
        $state_request->name = $request->json()->get('name');
        $state_request->save();
        return $state_request;
    }

    public function update(Request $request, $id){
        $state_request = StateRequest::where('id', $id)
                    ->first();
        $state_request->name = $request->json()->get('name');
        $state_request->updated_at = date('Y-m-d H:i:s');
        $state_request->save();
        return $state_request;
    }

    public function delete($id){
        StateRequest::where('id', $id)
            ->delete();
        return [
            'message' => 'State request deleted'
        ];
    }
}
