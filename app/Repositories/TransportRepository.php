<?php

namespace App\Repositories;

use App\Models\Transport;
use Exception;

class TransportRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return Transport::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $transport = new Transport();
            $transport->name = $request->json()->get('name');
            $transport->save();
            return $transport;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $transport = Transport::where('id', $id)
                        ->first();
            if($request->json()->get('name')) $transport->name = $request->json()->get('name');
            $transport->updated_at = date('Y-m-d H:i:s');
            $transport->save();
            return $transport;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Transport::where('id', $id)
                ->delete();
            return [
                'message' => 'Transport deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
