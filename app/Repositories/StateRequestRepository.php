<?php

namespace App\Repositories;

use App\Models\StateRequest;

class StateRequestRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return StateRequest::where('id', $id)
                    ->first();
    }

    public function create($request){
        $state_request = new StateRequest();
        $state_request->name = $request->json()->get('name');
        $state_request->save();
        return $state_request;
    }

    public function update($request, $id){
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
