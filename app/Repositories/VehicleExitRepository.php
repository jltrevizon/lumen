<?php

namespace App\Repositories;

use App\Models\VehicleExit;

class VehicleExitRepository extends Repository {


    public function getAll($request){
        return VehicleExit::with($this->getWiths($request->with))
                ->get();
    }

    public function getById($request, $id){
        return VehicleExit::with($this->getWiths($request->with))
                ->findOrFail($id);
    }

    public function create($request){
        $vehicleExit = VehicleExit::create($request->all());
        $vehicleExit->save();
        return $vehicleExit;
    }

    public function update($request, $id){
        $vehicleExit = VehicleExit::findOrFail($id);
        $vehicleExit->update($request->all());
        return $vehicleExit;
    }
}
