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
        $reception = new Reception();
        $reception->vehicle_id = $request->input('vehicle_id');
        $reception->has_accessories = false;
        $reception->save();
        return ['reception' => $reception];
    }

    public function getById($id){
        $reception = Reception::with(['vehicle.vehicleModel.brand','vehicle.subState.state'])
                        ->findOrFail($id);
        return ['reception' => $reception];
    }

    public function lastReception($vehicle_id){
        return Reception::where('vehicle_id', $vehicle_id)
                ->orderBy('id', 'DESC')
                ->first();
    }

    public function update($reception_id){
        $reception = Reception::findOrFail($reception_id);
        $reception->has_accessories = true;
        $reception->save();
        return $reception;
    }

}
