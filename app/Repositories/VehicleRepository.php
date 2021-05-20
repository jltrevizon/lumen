<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\DefleetVariableRepository;
class VehicleRepository {

    public function __construct(UserRepository $userRepository, CategoryRepository $categoryRepository, DefleetVariableRepository $defleetVariableRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->defleetVariableRepository = $defleetVariableRepository;
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

    public function createFromExcel($request){
        $vehicles = $request->json()->get('vehicles');
        $array_vehicles = [];
        foreach($vehicles as $vehicle){
            $new_vehicle = new Vehicle();
            if($vehicle['remote_id']) $new_vehicle->remote_id = $vehicle['remote_id'];
            $new_vehicle->campa_id = $vehicle['campa_id'];
            $category = $this->categoryRepository->searchCategoryByName($vehicle['category']);
            $new_vehicle->category_id = $category->id;
            $new_vehicle->state_id = $vehicle['state_id'];
            $new_vehicle->ubication = $vehicle['ubication'];
            $new_vehicle->plate = $vehicle['plate'];
            $new_vehicle->branch = $vehicle['branch'];
            $new_vehicle->trade_state_id = 1;
            $new_vehicle->vehicle_model = $vehicle['vehicle_model'];
            if($vehicle['kms']) $new_vehicle->kms = $vehicle['kms'];
            $new_vehicle->priority = $vehicle['priority'];
            if($vehicle['version']) $new_vehicle->version = $vehicle['version'];
            if($vehicle['vin']) $new_vehicle->vin = $vehicle['vin'];
            $new_vehicle->first_plate = $vehicle['first_plate'];
            if($vehicle['latitude']) $new_vehicle->latitude = $vehicle['latitude'];
            if($vehicle['longitude']) $new_vehicle->longitude = $vehicle['longitude'];
            $new_vehicle->save();
            array_push($array_vehicles, $new_vehicle);
        }
        return $array_vehicles;
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

    public function getAllByCompany($request){
        if($request->json()->get('limit')){
            $vehicles = Vehicle::with(['campa','state','category'])
                ->whereHas('campa', function (Builder $builder) use($request){
                    return $builder->where('company_id', $request->json()->get('company_id'));
                })
                ->offset($request->json()->get('offset'))
                ->limit($request->json()->get('limit'))
                ->get();
            $total_vehicles = Vehicle::with(['campa','state','category'])
                ->whereHas('campa', function (Builder $builder) use($request){
                    return $builder->where('company_id', $request->json()->get('company_id'));
                })
                ->count();
            return [
                'vehicles' => $vehicles,
                'total' => $total_vehicles
            ];
        }
        $vehicles = Vehicle::with(['campa','state','category'])
                ->whereHas('campa', function (Builder $builder) use($request){
                    return $builder->where('company_id', $request->json()->get('company_id'));
                })
                ->get();
            $total_vehicles = Vehicle::with(['campa','state','category'])
                ->whereHas('campa', function (Builder $builder) use($request){
                    return $builder->where('company_id', $request->json()->get('company_id'));
                })
                ->count();
            return [
                'vehicles' => $vehicles,
                'total' => $total_vehicles
            ];
    }

    public function getAllByCampa($request){
        if($request->json()->get('limit')){
            $vehicles = Vehicle::with(['campa','state','category'])
                ->where('campa_id', $request->json()->get('campa_id'))
                ->offset($request->json()->get('offset'))
                ->limit($request->json()->get('limit'))
                ->get();
            $total_vehicles = Vehicle::with(['campa','state','category'])
                ->where('campa_id', $request->json()->get('campa_id'))
                ->count();
            return [
                'vehicles' => $vehicles,
                'total' => $total_vehicles
            ];
        }

        $vehicles = Vehicle::with(['campa','state','category'])
                ->where('campa_id', $request->json()->get('campa_id'))
                ->get();
            $total_vehicles = Vehicle::with(['campa','state','category'])
                ->where('campa_id', $request->json()->get('campa_id'))
                ->count();
            return [
                'vehicles' => $vehicles,
                'total' => $total_vehicles
            ];
    }

    public function getByPlate($request){
        return Vehicle::where('plate', $request->json()->get('plate'))
                    ->first();
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
        $vehicle->trade_state_id = 1;
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

    public function updateDocumentation($request, $id){
        $vehicle = Vehicle::where('id', $id)
                    ->first();
        $vehicle->documentation = $request->json()->get('documentation');
        $vehicle->save();
        return $vehicle;
    }

    public function updateState($vehicle_id, $state_id){
        $vehicle = Vehicle::where('id', $vehicle_id)
                        ->first();
        $vehicle->state_id = $state_id;
        $vehicle->save();
    }

    public function updateTradeState($vehicle_id, $trade_state_id){
        $vehicle = Vehicle::where('id', $vehicle_id)
                        ->first();
        $vehicle->trade_state_id = $trade_state_id;
        $vehicle->save();
    }

    public function verifyPlate($request){
        $user = $this->userRepository->getById(Auth::id());

        $vehicle = Vehicle::with(['campa.company'])
                    ->where('plate', $request->json()->get('plate'))
                    ->where('campa_id', $user->campa_id)
                    ->first();
        $variables_defleet = $this->defleetVariableRepository->getVariablesByCompany($vehicle['campa']['company_id']);
        $date_first_plate = new DateTime($vehicle->first_plate);
        $date = date("Y-m-d H:i:s");
        $today = new DateTime($date);
        $diff = $date_first_plate->diff($today);
        $year = $diff->format('%Y');
        if($vehicle->kms > $variables_defleet->kms || $year > $variables_defleet->years){
            return response()->json(['message' => 'Vehículo para defletar']);
        }
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

    public function VehiclesReserveByCompany($request){
        return Vehicle::with(['category','campa','state','trade_state', ])
                    ->whereHas('campa', function (Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('trade_state_id', 6)
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

    public function getVehiclesAvailableReserveByCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','pending_tasks' => function ($query) {
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhere('state_pending_task_id', null);
                    }])
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->where('trade_state_id', 1)
                    ->get();
    }

    public function getVehiclesAvailableReserveByCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','pending_tasks' => function ($query) {
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhere('state_pending_task_id', null);
                    }])
                    ->whereHas('campa', function (Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('trade_state_id', 1)
                    ->get();
    }

    public function vehiclesReservedByCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','reservations', 'requests.customer'])
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->where('trade_state_id', 2)
                    ->get();
    }

    public function vehiclesReservedByCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','reservations', 'requests.customer'])
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('trade_state_id', 2)
                    ->get();
    }

    public function vehiclesByStateCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','pending_tasks' => function ($query) {
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhere('state_pending_task_id', null);
                    }])
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->where('state_id', $request->json()->get('state_id'))
                    ->whereNull('trade_state_id')
                    ->get();
    }

    public function vehiclesByStateCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','pending_tasks' => function ($query) {
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhere('state_pending_task_id', null);
                    }])
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('state_id', $request->json()->get('state_id'))
                    ->whereNull('trade_state_id')
                    ->get();
    }

    public function vehiclesByTradeStateCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','pending_tasks' => function($query){
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhereNull('state_pending_task_id');
                    }])
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->where('trade_state_id', $request->json()->get('trade_state_id'))
                    ->get();
    }

    public function vehiclesByTradeStateCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','pending_tasks' => function($query){
                        return $query->where('state_pending_task_id', '!=', 3)
                                    ->orWhereNull('state_pending_task_id');
                    }])
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('trade_state_id', $request->json()->get('trade_state_id'))
                    ->get();
    }

    public function getVehiclesReadyToDeliveryCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations'])
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->where('ready_to_delivery', true)
                    ->get();
    }

    public function getVehiclesReadyToDeliveryCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations'])
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->where('ready_to_delivery', true)
                    ->get();
    }

    public function getVehiclesWithReservationWithoutOrderCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                        return $query->whereNull('order')
                                    ->where('active', true);
                    }])
                    ->whereHas('reservations', function(Builder $builder) use($request){
                        return $builder->whereNull('order')
                                    ->where('active', true);
                    })
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->get();
    }

    public function getVehiclesWithReservationWithoutOrderCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                        return $query->whereNull('order')
                                    ->where('active', true);
                    }])
                    ->whereHas('reservations', function(Builder $builder) use($request){
                        return $builder->whereNull('order')
                                    ->where('active', true);
                    })
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->get();
    }

    public function getVehiclesWithReservationWithoutContractCampa($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                        return $query->whereNotNull('order')
                                    ->whereNull('contract')
                                    ->where('active', true);
                    }])
                    ->whereHas('reservations', function(Builder $builder) use($request){
                        return $builder->whereNotNull('order')
                                    ->whereNull('contract')
                                    ->where('active', true);
                    })
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->get();
    }

    public function getVehiclesWithReservationWithoutContractCompany($request){
        return Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                        return $query->whereNotNull('order')
                                    ->whereNull('contract')
                                    ->where('active', true);
                    }])
                    ->whereHas('reservations', function(Builder $builder) use($request){
                        return $builder->whereNotNull('order')
                                    ->whereNull('contract')
                                    ->where('active', true);
                    })
                    ->whereHas('campa', function(Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                    ->get();
    }


}
