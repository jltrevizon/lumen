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
            return response()->json(['transport' => Transport::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $transport = Transport::create($request->all());
            $transport->save();
            return $transport;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $transport = Transport::findOrFail($id);
            $transport->update($request->all());
            return response()->json(['transport' => $transport], 200);
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
