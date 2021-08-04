<?php

namespace App\Repositories;

use App\Models\Transport;
use Exception;

class TransportRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return ['transport' => Transport::findOrFail($id)];
    }

    public function create($request){
        $transport = Transport::create($request->all());
        $transport->save();
        return $transport;
    }

    public function update($request, $id){
        $transport = Transport::findOrFail($id);
        $transport->update($request->all());
        return ['transport' => $transport];
    }

    public function delete($id){
        Transport::where('id', $id)
            ->delete();
        return [ 'message' => 'Transport deleted' ];
    }
}
