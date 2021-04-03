<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function getAll(){
        return Vehicle::all();
    }

    public function getById($id){
        return Vehicle::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $vehicle = new Vehicle();
        if(isset($request['remote_id'])) $vehicle->remote_id = $request->get('remote_id');
        $vehicle->campa_id = $request->get('campa_id');
        $vehicle->category_id = $request->get('category_id');
        if(isset($request['state_id'])) $vehicle->state_id = $request->get('state_id');
        $vehicle->ubication = $request->get('ubication');
        $vehicle->plate = $request->get('plate');
        $vehicle->branch = $request->get('branch');
        $vehicle->vehicle_model = $request->get('vehicle_model');
        if(isset($request['version'])) $vehicle->version = $request->get('version');
        if(isset($request['vin'])) $vehicle->vin = $request->get('vin');
        $vehicle->first_plate = $request->get('first_plate');
        $vehicle->save();
        return $vehicle;
    }

    public function update(Request $request, $id){
        $vehicle = Vehicle::where('id', $id)
                    ->first();
        if(isset($request['remote_id'])) $vehicle->remote_id = $request->get('remote_id');
        if(isset($request['campa_id'])) $vehicle->campa_id = $request->get('campa_id');
        if(isset($request['category_id'])) $vehicle->category_id = $request->get('category_id');
        if(isset($request['state_id'])) $vehicle->state_id = $request->get('state_id');
        if(isset($request['ubication'])) $vehicle->ubication = $request->get('ubication');
        if(isset($request['plate'])) $vehicle->plate = $request->get('plate');
        if(isset($request['branch'])) $vehicle->branch = $request->get('branch');
        if(isset($request['vehicle_model'])) $vehicle->vehicle_model = $request->get('vehicle_model');
        if(isset($request['version'])) $vehicle->version = $request->get('version');
        if(isset($request['vin'])) $vehicle->vin = $request->get('vin');
        if(isset($request['first_plate'])) $vehicle->first_plate = $request->get('first_plate');
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
