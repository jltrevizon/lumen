<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\DefleetVariableRepository;
use App\Repositories\GroupTaskRepository;
use App\Repositories\StateRepository;
use App\Repositories\BrandRepository;
use App\Repositories\VehicleModelRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class VehicleRepository {

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        DefleetVariableRepository $defleetVariableRepository,
        StateRepository $stateRepository,
        GroupTaskRepository $groupTaskRepository,
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->defleetVariableRepository = $defleetVariableRepository;
        $this->stateRepository = $stateRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
    }

    public function getById($id){
        try {
            return Vehicle::with(['campa','vehicleModel.brand'])
                        ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 409);
        }
    }

    public function filterVehicle($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['subState.state','campa','category','trade_state','requests.customer','reservations','vehicleModel.brand'])
                        ->campasIds($request->input('campas'))
                        ->stateIds($request->input('states'))
                        ->plate($request->input('plate'))
                        ->brandIds($request->input('brands'))
                        ->where(function($query) use($request) {
                            if(count($request->input('trade_states')) > 0) return $query->whereIn('trade_state_id', $request->input('trade_states'));
                            else return $query->whereNull('trade_state_id');
                        })
                        ->categoriesIds($request->input('categories'))
                        ->paginate($request->input('limit'));
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }

    }

    public function createFromExcel($request) {
        try {
            $vehicles = $request->input('vehicles');
            $array_vehicles = [];
            foreach($vehicles as $vehicle){
                $new_vehicle = new Vehicle();
                if($vehicle['remote_id'] ?? null) $new_vehicle->remote_id = $vehicle['remote_id'];
                if($vehicle['campa_id'] ?? null) $new_vehicle->campa_id = $vehicle['campa_id'];
                $category = $this->categoryRepository->searchCategoryByName($vehicle['category']);
                if($category['id'] ?? null ) $new_vehicle->category_id = $category['id'];
                $new_vehicle->ubication = $vehicle['ubication'];
                $new_vehicle->plate = $vehicle['plate'];
                $brand = $this->brandRepository->getByNameFromExcel($vehicle['brand']);
                $vehicle_model = $this->vehicleModelRepository->getByNameFromExcel($brand['id'], $vehicle['vehicle_model']);
                $new_vehicle->vehicle_model_id = $vehicle_model['id'];
                $new_vehicle->trade_state_id = null;
                if($vehicle['kms'] ?? null) $new_vehicle->kms = $vehicle['kms'];
                if($vehicle['priority'] ?? null) $new_vehicle->priority = $vehicle['priority'];
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

    public function getByPlate($request) {
        try {
            $vehicle = Vehicle::where('plate', $request->json()->get('plate'))
                       ->first();
            return $vehicle;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request): JsonResponse {
        try {
            $vehicle = Vehicle::create($request->all());
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

    public function updateBack($request): JsonResponse
    {
        try {
            $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
            $vehicle->update($request->all());
            return response()->json([ 'vehicle' => $vehicle ], 200);
        } catch (\Exception $e) {
            return response()->json([ 'message' => $e ], 409);
        }
    }

    public function updateCampa($vehicle_id, $campa){
        try {
            $vehicle = Vehicle::findOrFail($vehicle_id);
            $vehicle->campa_id = $campa;
            $vehicle->save();
            return $vehicle;
        } catch (Exception $e) {
            return response()->json([ 'message' => $e ], 409);
        }
    }

    public function updateState($vehicle_id, $state_id): JsonResponse {
        try {
            $vehicle = Vehicle::findOrFail($vehicle_id);
            $vehicle->sub_state_id = $state_id;
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
            $vehicleDefleet = Vehicle::whereHas('requests', function (Builder $builder) {
                return $builder->where('type_request_id', 1)
                            ->where(function($query) {
                                return $query->where('state_request_id', 1)
                                            ->orWhere('state_request_id', 2);
                            });
            })
            ->where('plate', $request->input('plate'))
            ->first();
            if($vehicleDefleet){
                return response()->json(['defleet' => true, 'vehicle' => $vehicleDefleet], 200);
            }

            $vehicle = Vehicle::with(['campa.company','requests.state_request','requests.type_request', 'requests' => function ($query) {
                            return $query->where('state_request_id', 1);
                        }])
                        ->where('plate', $request->input('plate'))
                        //->where('campa_id', $user->campa_id)
                        ->first();

            if($vehicle){
                return response()->json(['vehicle' => $vehicle, 'registered' => true], 200);
            } else {
                return response()->json(['registered' => false], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function verifyPlateReception($request){
        try {
            $user = $this->userRepository->getById(Auth::id());

            $vehicle = Vehicle::with(['campa.company'])
                        ->where('plate', $request->input('plate'))
                        //->where('campa_id', $user->campa_id)
                        ->first();

            if($vehicle){
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
                return response()->json(['vehicle' => $vehicle, 'registered' => true], 200);
            } else {
                return response()->json(['registered' => false], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleDefleet($request) {
        try {
            $user = $this->userRepository->getById(Auth::id());

            $variables = $this->defleetVariableRepository->getVariablesByCompany($user->company_id);
            $date = date("Y-m-d");
            $date1 = new DateTime($date);
            $date_defleet = date("Y-m-d", strtotime($date . " - $variables->years years")) . ' 00:00:00';
           // return $date_defleet;
            $vehicles = Vehicle::with(['campa','category','subState.state'])
                            ->where(function($query) {
                                return $query->whereHas('requests', function(Builder $builder) {
                                    return $builder->where('state_request_id', 3);
                                })
                                ->orWhereDoesntHave('requests');
                            })
                            ->where(function($query) use($date_defleet, $variables){
                                return $query->where('first_plate','<',$date_defleet)
                                            ->orWhere('kms','>',$variables->kms);
                            })
                            ->whereIn('campa_id', $request->input('campas'))
                            ->paginate($request->input('limit'));

            return response()->json(['vehicles' => $vehicles], 200);
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
                        ->whereIn('campa_id', $request->input('campas'))
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
                            return $builder->where('company_id', $request->input('company_id'));
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
            $vehicles = Vehicle::with(['vehicleModel.brand','category','campa','subState.state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                            return $query->where(function ($query) {
                                return $query->whereNull('order');
                            })
                            ->orWhere(function ($query) {
                                return $query->whereNotNull('order')
                                    ->whereNull('pickup_by_customer')
                                    ->whereNull('transport_id');
                            })
                            ->where('active', true);
                        }])
                        ->whereHas('reservations', function(Builder $builder) use($request){
                            return $builder->where(function ($query) {
                                return $query->whereNull('order');
                            })
                            ->orWhere(function ($query) {
                                return $query->whereNotNull('order')
                                    ->whereNull('pickup_by_customer')
                                    ->whereNull('transport_id');
                            })
                            ->where('active', true);
                        })
                        ->whereIn('campa_id', $request->input('campas'))
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVehiclesWithReservationWithoutContractCampa($request): JsonResponse {
        try {
            $vehicles = Vehicle::with(['vehicleModel.brand','category','campa','subState.state','trade_state','requests.customer','reservations.transport','reservations' => function($query){
                            return $query->whereNotNull('order')
                                        ->whereNull('contract')
                                        ->where('active', true)
                                        ->where(function($query) {
                                            return $query->whereNotNull('pickup_by_customer')
                                                        ->orWhereNotNull('transport_id');
                                        });
                        }])
                        ->whereHas('reservations', function(Builder $builder) use($request){
                            return $builder->whereNotNull('order')
                                        ->whereNull('contract')
                                        ->where('active', true)
                                        ->where(function($query) {
                                            return $query->whereNotNull('pickup_by_customer')
                                                        ->orWhereNotNull('transport_id');
                                        });
                        })
                        ->whereIn('campa_id', $request->input('campas'))
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleReserved(){
        try {
            $user = $this->userRepository->getById(Auth::id());
            return Vehicle::with(['reservations' => fn ($query) => $query->where('active', true)])
                        ->whereHas('reservations', fn (Builder $builder) => $builder->where('active', true))
                        ->whereHas('campa', function (Builder $builder) use ($user){
                            return $builder->whereIn('id', $user->campas->pluck('id')->toArray());
                        })
                        ->get();
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleTotalsState($request){
        try {
            return Vehicle::with(['subState.state'])
                        ->whereIn('campa_id', $request->input('campas'))
                        ->select(DB::raw('sub_state_id, COUNT(*) AS count'))
                        ->groupBy('sub_state_id')
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleRequestDefleet(){
        try {
            $user = $this->userRepository->getById(Auth::id());
            $vehicles = Vehicle::with(['requests','vehicleModel.brand'])
                        ->whereHas('requests', function (Builder $builder) {
                            return $builder->where('type_request_id', 1)
                                        ->where('state_request_id', 1);
                        })
                        ->where('trade_state_id', 4)
                        ->whereIn('campa_id', $user->campas->pluck('id')->toArray())
                        ->whereHas('subState.state',function($query){
                            return $query->where('id', '<>', 3);
                        })
                        ->get();
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehiclesByState($request){
        try {
            return Vehicle::with(['vehicleModel.brand','category','campa','subState.state','trade_state'])
                        ->whereHas('subState.state', function (Builder $builder) use($request) {
                            return $builder->whereIn('id', $request->input('states'));
                        })
                        ->whereHas('requests', function (Builder $builder) use($request) {
                            return $builder->where('type_request_id', 1)
                                        ->where('datetime_approved', '>=', $request->input('date_start') . ' 00:00:00')
                                        ->where('datetime_approved','<=', $request->input('date_end') . ' 23:59:59');
                        })
                        ->whereIn('campa_id', $request->input('campas'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
