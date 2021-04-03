<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestVehicle;

class RequestController extends Controller
{
    public function getAll(){
        return RequestVehicle::all();
    }

    public function getById($id){
        return RequestVehicle::where('id', $id)
                        ->first();
    }

    public function create(Request $request){
        $request_vehicle = new RequestVehicle();
        $request_vehicle->vehicle_id = $request->get('vehicle_id');
        $request_vehicle->state_request_id = $request->get('state_request_id');
        $request_vehicle->type_request_id = $request->get('type_request_id');
        $request_vehicle->save();
        return $request_vehicle;
    }

    public function update(Request $request, $id){
        $request_vehicle = RequestVehicle::where('id', $id)
                            ->first();
        if(isset($request['vehicle_id'])) $request_vehicle->vehicle_id = $request->get('vehicle_id');
        if(isset($request['state_request_id'])) $request_vehicle->state_request_id = $request->get('state_request_id');
        if(isset($request['type_request_id'])) $request_vehicle->type_request_id = $request->get('type_request_id');
        $request_vehicle->updated_at = date('Y-m-d H:i:s');
        $request_vehicle->save();
        return $request_vehicle;
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [
            'message' => 'Request deleted'
        ];
    }
}
