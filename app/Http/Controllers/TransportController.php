<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;

class TransportController extends Controller
{
    public function getAll(){
        return Transport::all();
    }

    public function getById($id){
        return Transport::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $transport = new Transport();
        $transport->name = $request->get('name');
        $transport->save();
        return $transport;
    }

    public function update(Request $request, $id){
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
