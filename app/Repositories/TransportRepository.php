<?php

namespace App\Repositories;

use App\Models\TypeRequest;

class TransportRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return TypeRequest::where('id', $id)
                    ->first();
    }

    public function create($request){
        $type_request = new TypeRequest();
        $type_request->name = $request->json()->get('name');
        $type_request->save();
        return $type_request;
    }

    public function update($request, $id){
        $type_request = TypeRequest::where('id', $id)
                    ->first();
        if(isset($request['name'])) $type_request->name = $request->json()->get('name');
        $type_request->updated_at = date('Y-m-d H:i:s');
        $type_request->save();
        return $type_request;
    }

    public function delete($id){
        TypeRequest::where('id', $id)
            ->delete();
        return [
            'message' => 'Type request deleted'
        ];
    }
}
