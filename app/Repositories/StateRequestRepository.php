<?php

namespace App\Repositories;

use App\Models\StateRequest;
use Exception;

class StateRequestRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return ['state_request' => StateRequest::findOrFail($id)];
    }

    public function create($request){
        $state_request = StateRequest::create($request->all());
        $state_request->save();
        return $state_request;
    }

    public function update($request, $id){
        $state_request = StateRequest::findOrFail($id);
        $state_request->update($request->all());
        return response()->json(['state_request' => $state_request], 200);
    }

    public function delete($id){
        StateRequest::where('id', $id)
            ->delete();
        return [ 'message' => 'State request deleted' ];
    }

}
