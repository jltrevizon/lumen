<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestVehicle;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
        $array_request = [];
        $vehicles = $request->json()->get('vehicles');
        $request_active = false;
        foreach($vehicles as $vehicle){
            $request_vehicle = new RequestVehicle();
            $request_active = RequestVehicle::where('vehicle_id', $vehicle['vehicle_id'])
                                            ->where('state_request_id', 1)
                                            ->get();
            if(count($request_active) > 0){

            } else {
                $request_vehicle->vehicle_id = $vehicle['vehicle_id'];
                $request_vehicle->state_request_id = 1;
                $request_vehicle->type_request_id = $vehicle['type_request_id'];
                $request_vehicle->datetime_request = date('Y-m-d H:i:s');
                $request_vehicle->save();
                array_push($array_request, $request_vehicle);
            }
        }
        if($request_active == true){
            return [
                'message' => 'Existen vehículos que tienen una solicitud activa',
                'requests' => $array_request
            ];
        }
        return $array_request;
    }

    public function update(Request $request, $id){
        $request_vehicle = RequestVehicle::where('id', $id)
                            ->first();
        if($request->json()->get('vehicle_id')) $request_vehicle->vehicle_id = $request->get('vehicle_id');
        if($request->json()->get('state_request_id')) $request_vehicle->state_request_id = $request->get('state_request_id');
        if($request->json()->get('type_request_id')) $request_vehicle->type_request_id = $request->get('type_request_id');
        $request_vehicle->updated_at = date('Y-m-d H:i:s');
        $request_vehicle->save();
        return $request_vehicle;
    }

    public function vehiclesRequestedDefleet(Request $request){
        return RequestVehicle::with(['vehicle.state','vehicle.category','vehicle.campa','state_request','type_request'])
                            ->whereHas('vehicle', function(Builder $builder) use ($request){
                                return $builder->where('campa_id', $request->json()->get('campa_id'));
                            })
                            ->where('type_request_id', 1)
                            ->where('state_request_id', 1)
                            ->get();
    }

    public function confirmedRequest(Request $request){
        $request_vehicle = RequestVehicle::where('id', $request->json()->get('request_id'))
                                    ->first();
        $request_vehicle->state_request_id = 2;
        $request_vehicle->save();
        return RequestVehicle::with(['state_request'])
                        ->where('id', $request->json()->get('request_id'))
                        ->first();
    }

    public function declineRequest(Request $request){
        return  'hola';
        $request_vehicle = RequestVehicle::where('id', $request->json()->get('request_id'))
                                    ->first();
        $request_vehicle->state_request_id = 3;
        $request_vehicle->save();
        return RequestVehicle::with(['state_request'])
                        ->where('id', $request->json()->get('request_id'))
                        ->first();
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [
            'message' => 'Request deleted'
        ];
    }
}
