<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleExit;
use Illuminate\Support\Facades\Auth;

class VehicleExitRepository extends Repository {

    public function getAll($request){
        return VehicleExit::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page'));
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

    public function registerExit($vehicle_id, $deliveryNoteId, $campaId){
        $user = User::findOrFail(Auth::id());
        $vehicleExit = new VehicleExit();
        $vehicleExit->vehicle_id = $vehicle_id;
        $vehicleExit->campa_id = $campaId;
        $vehicleExit->delivery_note_id = $deliveryNoteId;
        $vehicleExit->delivery_by = $user->name;
        $vehicleExit->date_delivery = date('Y-m-d');
        $vehicleExit->save();
    }
}
