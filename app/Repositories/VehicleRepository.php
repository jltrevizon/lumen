<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VehicleRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById($id){
        return Vehicle::with(['campa'])
                    ->where('id', $id)
                    ->first();
    }

    public function getByCampaWithoutReserve($request){
        return Vehicle::with(['state','campa','category'])
                    ->whereHas('requests', function(Builder $builder) use ($request) {
                        return $builder->where('state_request_id', 3);
                    })
                    ->orWhereDoesntHave('requests')
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->get();
    }

    public function getByCompany($request){
        return Vehicle::with(['campa','state','category'])
                ->whereHas('requests', function(Builder $builder) use ($request) {
                    return $builder->where('state_request_id', 3);
                })
                ->orWhereDoesntHave('requests')
                ->whereHas('campa', function(Builder $builder) use ($request) {
                    return $builder->where('company_id', $request->json()->get('company_id'));
                })
                ->get();
    }

    public function create($request){
        $vehicle = new Vehicle();
        if($request->json()->get('remote_id')) $vehicle->remote_id = $request->json()->get('remote_id');
        $vehicle->campa_id = $request->json()->get('campa_id');
        $vehicle->category_id = $request->json()->get('category_id');
        if($request->json()->get('state_id')) $vehicle->state_id = $request->json()->get('state_id');
        if($request->json()->get('kms')) $vehicle->kms = $request->json()->get('kms');
        $vehicle->ubication = $request->json()->get('ubication');
        $vehicle->plate = $request->json()->get('plate');
        $vehicle->branch = $request->json()->get('branch');
        $vehicle->vehicle_model = $request->json()->get('vehicle_model');
        if($request->json()->get('version')) $vehicle->version = $request->json()->get('version');
        if($request->json()->get('vin')) $vehicle->vin = $request->json()->get('vin');
        $vehicle->first_plate = $request->json()->get('first_plate');
        $vehicle->save();
        return $vehicle;
    }

    public function update($request, $id){
        $vehicle = Vehicle::where('id', $id)
                    ->first();
        if($request->json()->get('remote_id')) $vehicle->remote_id = $request->json()->get('remote_id');
        if($request->json()->get('campa_id')) $vehicle->campa_id = $request->json()->get('campa_id');
        if($request->json()->get('category_id')) $vehicle->category_id = $request->json()->get('category_id');
        if($request->json()->get('state_id')) $vehicle->state_id = $request->json()->get('state_id');
        if($request->json()->get('ubication')) $vehicle->ubication = $request->json()->get('ubication');
        if($request->json()->get('plate')) $vehicle->plate = $request->json()->get('plate');
        if($request->json()->get('kms')) $vehicle->kms = $request->json()->get('kms');
        if($request->json()->get('branch')) $vehicle->branch = $request->json()->get('branch');
        if($request->json()->get('vehicle_model')) $vehicle->vehicle_model = $request->json()->get('vehicle_model');
        if($request->json()->get('version')) $vehicle->version = $request->json()->get('version');
        if($request->json()->get('vin')) $vehicle->vin = $request->json()->get('vin');
        if($request->json()->get('first_plate')) $vehicle->first_plate = $request->json()->get('first_plate');
        $vehicle->updated_at = date('Y-m-d H:i:s');
        $vehicle->save();
        return $vehicle;
    }

    public function updateState($vehicle_id, $state_id){
        $vehicle = Vehicle::where('id', $vehicle_id)
                        ->first();
        $vehicle->state_id = $state_id;
        $vehicle->save();
    }

    public function verifyPlate($request){
        $user = $this->userRepository->getById(Auth::id());

        $vehicle = Vehicle::where('plate', $request->json()->get('plate'))
                    ->where('campa_id', $user->campa_id)
                    ->first();
        if($vehicle){
            return response()->json(['vehicle' => $vehicle, 'registered' => true], 200);
        } else {
            return response()->json(['registered' => false], 200);
        }
    }

    public function vehicleDefleet($request){
        $variables = DefleetVariable::first();
        $date = date("Y-m-d");
        $date1 = new DateTime($date);
        $vehicles = Vehicle::with(['campa','category','state'])
                        ->whereHas('requests', function(Builder $builder) use ($request) {
                            return $builder->where('state_request_id', 3);
                        })
                        ->orWhereDoesntHave('requests')
                        ->where('campa_id', $request->json()->get('campa_id'))
                        ->get();
        $array_vehicles = [];
        foreach($vehicles as $vehicle){
            $date2 = new DateTime($vehicle['first_plate']);
            $diff = $date1->diff($date2);
            $age = $diff->y;
            if($age > $variables->years || $vehicle['kms'] > $variables->kms){
                array_push($array_vehicles, $vehicle);
            }
        }
        return $array_vehicles;
    }

    public function delete($id){
        Vehicle::where('id', $id)
            ->delete();
        return [
            'message' => 'Vehicle deleted'
        ];
    }

    public function updateGeolocation($request){
        $vehicle = Vehicle::where('id', $request->json()->get('vehicle_id'))
                    ->first();
        $vehicle->latitude = $request->json()->get('latitude');
        $vehicle->longitude = $request->json()->get('longitude');
        $vehicle->save();
    }

    public function vehiclesDefleeted(){
        $user = $this->userRepository->getById(Auth::id());
        return Vehicle::with(['state'])
                    ->where('state_id', 3)
                    ->where('campa_id', $user->campa_id)
                    ->get();
    }

    public function vehiclesReserved(){
        $user = $this->userRepository->getById(Auth::id());
        return Vehicle::with(['state'])
                    ->where('state_id', 2)
                    ->where('campa_id', $user->campa_id)
                    ->get();
    }

    public function vehiclesDefleetByCampa(){
        $user = $this->userRepository->getById(Auth::id());
        $variables = DefleetVariable::first();
        $date = date("Y-m-d");
        $date1 = new DateTime($date);
        $vehicles = Vehicle::with(['campa','category','state'])
                        ->whereHas('requests', function(Builder $builder) {
                            return $builder->where('state_request_id', 3);
                        })
                        ->orWhereDoesntHave('requests')
                        ->where('campa_id', $user->campa_id)
                        ->get();
        $array_vehicles = [];
        foreach($vehicles as $vehicle){
            $date2 = new DateTime($vehicle['first_plate']);
            $diff = $date1->diff($date2);
            $age = $diff->y;
            if($age > $variables->years || $vehicle['kms'] > $variables->kms){
                array_push($array_vehicles, $vehicle);
            }
        }
        return $array_vehicles;
    }

}
