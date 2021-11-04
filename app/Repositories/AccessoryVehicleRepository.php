<?php

namespace App\Repositories;

use App\Models\AccessoryVehicle;
use App\Models\Vehicle;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class AccessoryVehicleRepository extends Repository {

    public function index($request){
        return DB::table('accessory_vehicle')
            ->get();
    }

    public function store($request){
        $accessories = $request->input('accessories');
        foreach ($accessories as $accessory) {
            DB::table('accessory_vehicle')->insert([
                'accessory_id' => $accessory,
                'vehicle_id' => $request->input('vehicle_id')
            ]);
        }
        return Vehicle::with('accessories')
            ->where('id', $request->input('vehicle_id'))
            ->first();
    }

    public function delete($request){
        $accessories = $request->input('accessories');
        foreach($accessories as $accessory){
            DB::table('accessory_vehicle')
            ->where('accessory_id', $accessory)
            ->where('vehicle_id', $request->input('vehicle_id'))
            ->delete();
        }
        return Vehicle::with('accessories')
            ->where('id', $request->input('vehicle_id'))
            ->first();
    }

}
