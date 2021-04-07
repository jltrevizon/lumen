<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function getAll(){
        return Vehicle::with(['campa'])
                    ->get();
    }

    public function getById($id){
        return Vehicle::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $vehicle = new Vehicle();
        $vehicle->remote_id = $request->json()->get('remote_id');
        $vehicle->campa_id = $request->json()->get('campa_id');
        $vehicle->category_id = $request->json()->get('category_id');
        $vehicle->state_id = $request->json()->get('state_id');
        $vehicle->ubication = $request->json()->get('ubication');
        $vehicle->plate = $request->json()->get('plate');
        $vehicle->branch = $request->json()->get('branch');
        $vehicle->vehicle_model = $request->json()->get('vehicle_model');
        $vehicle->version = $request->json()->get('version');
        $vehicle->vin = $request->json()->get('vin');
        $vehicle->first_plate = $request->json()->get('first_plate');
        $vehicle->save();
        return $vehicle;
    }

    public function update(Request $request, $id){
        $vehicle = Vehicle::where('id', $id)
                    ->first();
        if($request->json()->get('remote_id')) $vehicle->remote_id = $request->json()->get('remote_id');
        if($request->json()->get('campa_id')) $vehicle->campa_id = $request->json()->get('campa_id');
        if($request->json()->get('category_id')) $vehicle->category_id = $request->json()->get('category_id');
        if($request->json()->get('state_id')) $vehicle->state_id = $request->json()->get('state_id');
        if($request->json()->get('ubication')) $vehicle->ubication = $request->json()->get('ubication');
        if($request->json()->get('plate')) $vehicle->plate = $request->json()->get('plate');
        if($request->json()->get('branch')) $vehicle->branch = $request->json()->get('branch');
        if($request->json()->get('vehicle_model')) $vehicle->vehicle_model = $request->json()->get('vehicle_model');
        if($request->json()->get('version')) $vehicle->version = $request->json()->get('version');
        if($request->json()->get('vin')) $vehicle->vin = $request->json()->get('vin');
        if($request->json()->get('first_plate')) $vehicle->first_plate = $request->json()->get('first_plate');
        $vehicle->updated_at = date('Y-m-d H:i:s');
        $vehicle->save();
        return $vehicle;
    }

    public function delete($id){
        Vehicle::where('id', $id)
            ->delete();
        return [
            'message' => 'Vehicle deleted'
        ];
    }
}
