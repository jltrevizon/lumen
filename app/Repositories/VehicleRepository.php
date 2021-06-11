<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\DefleetVariableRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;

class VehicleRepository {

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        DefleetVariableRepository $defleetVariableRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->defleetVariableRepository = $defleetVariableRepository;
    }

    public function getById($id){
        try{
            $vehicle = Vehicle::with(['campa'])
                        ->findOrFail($id);
            return response()->json(['vehicle' => $vehicle], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 409);
        }
    }

    public function filterVehicle($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['state','campa','category','trade_state'])
                        ->campasIds($request->input('campas'))
                        ->stateIds($request->input('states'))
                        ->vehicleModel($request->input('vehicle_model'))
                        ->plate($request->input('plate'))
                        ->branch($request->input('branch'))
                        ->where(function ($query) use($request){
                            return $query->whereNull('trade_state_id')
                                        ->orWhereIn('trade_state_id', $request->input('trade_states'));
                        })
                        ->categoriesIds($request->input('categories'))
                        ->paginate($request->input('limit'));
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createFromExcel($request): JsonResponse {
        try {
            $vehicles = $request->input('vehicles');
            $array_vehicles = [];
            foreach($vehicles as $vehicle){
                $new_vehicle = new Vehicle();
                if($vehicle['remote_id'] ?? null) $new_vehicle->remote_id = $vehicle['remote_id'];
                $new_vehicle->campa_id = $vehicle['campa_id'];
                $category = $this->categoryRepository->searchCategoryByName($vehicle['category']);
                $new_vehicle->category_id = $category->id;
                $new_vehicle->state_id = $vehicle['state_id'];
                $new_vehicle->ubication = $vehicle['ubication'];
                $new_vehicle->plate = $vehicle['plate'];
                $new_vehicle->branch = $vehicle['branch'];
                $new_vehicle->trade_state_id = 1;
                $new_vehicle->vehicle_model = $vehicle['vehicle_model'];
                if($vehicle['kms'] ?? null) $new_vehicle->kms = $vehicle['kms'];
                $new_vehicle->priority = $vehicle['priority'];
                if($vehicle['version'] ?? null) $new_vehicle->version = $vehicle['version'];
                if($vehicle['vin'] ?? null) $new_vehicle->vin = $vehicle['vin'];
                $new_vehicle->first_plate = $vehicle['first_plate'];
                if($vehicle['latitude'] ?? null) $new_vehicle->latitude = $vehicle['latitude'];
                if($vehicle['longitude'] ?? null) $new_vehicle->longitude = $vehicle['longitude'];
                $new_vehicle->save();
                array_push($array_vehicles, $new_vehicle);
            }
            return response()->json(['vehicles' => $array_vehicles], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getByPlate($request): JsonResponse {
        try {
            $vehicle = Vehicle::where('plate', $request->json()->get('plate'))
                       ->first();
            return response()->json(['vehicle' => $vehicle], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request): JsonResponse {
        try {
            $vehicle = new Vehicle();
            if($request->input('remote_id')) $vehicle->remote_id = $request->input('remote_id');
            $vehicle->campa_id = $request->input('campa_id');
            $vehicle->category_id = $request->input('category_id');
            if($request->input('state_id')) $vehicle->state_id = $request->input('state_id');
            if($request->input('kms')) $vehicle->kms = $request->input('kms');
            $vehicle->ubication = $request->input('ubication');
            $vehicle->plate = $request->input('plate');
            $vehicle->branch = $request->input('branch');
            $vehicle->trade_state_id = 1;
            $vehicle->vehicle_model = $request->input('vehicle_model');
            if($request->input('version')) $vehicle->version = $request->input('version');
            if($request->input('vin')) $vehicle->vin = $request->input('vin');
            $vehicle->first_plate = $request->input('first_plate');
            $vehicle->save();
            return response()->json(['vehicle' => $vehicle], 200);
        } catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id): JsonResponse
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->all());
            return response()->json([ 'vehicle' => $vehicle ], 200);
        } catch (\Exception $e) {
            return response()->json([ 'message' => $e ], 409);
        }
    }

    public function updateState($vehicle_id, $state_id): JsonResponse {
        try {
            $vehicle = Vehicle::findOrFail($vehicle_id);
            $vehicle->state_id = $state_id;
            $vehicle->save();
            return response()->json(['vehicle' => $vehicle], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function updateTradeState($vehicle_id, $trade_state_id): JsonResponse {
        try {
            $vehicle = Vehicle::findOrFail($vehicle_id);
            $vehicle->trade_state_id = $trade_state_id;
            $vehicle->save();
            return response()->json(['vehicle' => $vehicle], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function verifyPlate($request): JsonResponse {
        try {
            $user = $this->userRepository->getById(Auth::id());

            $vehicle = Vehicle::with(['campa.company'])
                        ->where('plate', $request->input('plate'))
                        //->where('campa_id', $user->campa_id)
                        ->first();
            $variables_defleet = $this->defleetVariableRepository->getVariablesByCompany($vehicle['campa']['company']['id']);
            $date_first_plate = new DateTime($vehicle->first_plate);
            $date = date("Y-m-d H:i:s");
            $today = new DateTime($date);
            $diff = $date_first_plate->diff($today);
            $year = $diff->format('%Y');
            if($variables_defleet){
                if(($vehicle->kms > $variables_defleet->kms || $year > $variables_defleet->years)){
                    //Si el vehículo cumple con los kpis de defleet se cambia el estado a solicitado por defleet a espera de que lleven el vehículo a la zona pendiente de venta V.O.
                    $this->updateTradeState($vehicle->id, 4);
                    return response()->json(['defleet' => true,'message' => 'Vehículo para defletar'], 200);
                }
            }
            if($vehicle){
                return response()->json(['vehicle' => $vehicle, 'registered' => true], 200);
            } else {
                return response()->json(['registered' => false], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleDefleet($request): JsonResponse {
        try {
            $variables = DefleetVariable::first();
            $date = date("Y-m-d");
            $date1 = new DateTime($date);
            $vehicles = Vehicle::with(['campa','category','state'])
                            ->whereHas('requests', function(Builder $builder) use ($request) {
                                return $builder->where('state_request_id', 3);
                            })
                            ->orWhereDoesntHave('requests')
                            ->where('campa_id', $request->input('campa_id'))
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
            return response()->json(['vehicles' => $array_vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id): JsonResponse {
        try {
            Vehicle::where('id', $id)
                ->delete();
            return response()->json(['message' => 'Vehicle deleted'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehiclesDefleetByCampa(): JsonResponse {
        try {
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
            return response()->json(['vehicles' => $array_vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVehiclesReadyToDeliveryCampa($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations'])
                        ->whereIn('campa_id', $request->json()->get('campas'))
                        ->where('ready_to_delivery', true)
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVehiclesReadyToDeliveryCompany($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations'])
                        ->whereHas('campa', function(Builder $builder) use($request){
                            return $builder->where('company_id', $request->json()->get('company_id'));
                        })
                        ->where('ready_to_delivery', true)
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVehiclesWithReservationWithoutOrderCampa($request): JsonResponse {
        try{
            $vehicles = Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                            return $query->whereNull('order')
                                        ->where('active', true);

                        }])
                        ->whereHas('reservations', function(Builder $builder) use($request){
                            return $builder->where(function($query){
                                return $query->where(function($query){
                                    return $query->whereNull('order')
                                                ->orWhereNotNull('order');
                                        });
                                    })
                                        ->where('active', true)
                                        ->whereNull('pickup_by_customer')
                                        ->whereNull('transport_id');
                        })
                        ->whereIn('campa_id', $request->json()->get('campas'))
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVehiclesWithReservationWithoutContractCampa($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['category','campa','state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                            return $query->whereNotNull('order')
                                        ->whereNull('contract')
                                        ->where('active', true);
                        }])
                        ->whereHas('reservations', function(Builder $builder) use($request){
                            return $builder->whereNotNull('order')
                                        ->whereNull('contract')
                                        ->where('active', true);
                        })
                        ->whereIn('campa_id', $request->json()->get('campas'))
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }


}
