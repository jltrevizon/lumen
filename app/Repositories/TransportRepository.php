<?php

namespace App\Repositories;

use App\Models\Transport;

class TransportRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return Transport::where('id', $id)
                    ->first();
    }

    public function create($request){
        $transport = new Transport();
        $transport->name = $request->get('name');
        $transport->save();
        return $transport;
    }

    public function update($request, $id){
        $transport = Transport::where('id', $id)
                    ->first();
        if(isset($request['name'])) $transport->name = $request->get('name');
        $transport->updated_at = date('Y-m-d H:i:s');
        $transport->save();
        return $transport;
    }

    public function delete($id){
        Transport::where('id', $id)
            ->delete();
        return [
            'message' => 'Transport deleted'
        ];
    }
}
