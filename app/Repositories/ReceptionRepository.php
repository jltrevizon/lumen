<?php

namespace App\Repositories;

use App\Models\Reception;
use App\Models\Request;
use Exception;

class ReceptionRepository {

    public function __construct()
    {

    }

    public function create($request){
        try {
            $reception = new Reception();
            $reception->vehicle_id = $request->input('vehicle_id');
            $reception->has_accessories = false;
            $reception->save();
            return response()->json(['reception' => $reception], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getById($id){
        try {
            $reception = Reception::with(['vehicle.vehicleModel.brand','vehicle.subState.state'])
                                ->findOrFail($id);
            return response()->json(['reception' => $reception], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function lastReception($vehicle_id){
        try {
            return Reception::where('vehicle_id', $vehicle_id)
                                ->orderBy('id', 'DESC')
                                ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($reception_id){
        try {
            $reception = Reception::findOrFail($reception_id);
            $reception->has_accessories = true;
            $reception->save();
            return $reception;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
