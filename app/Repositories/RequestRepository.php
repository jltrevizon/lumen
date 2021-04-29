<?php

namespace App\Repositories;
use App\Models\Request as RequestVehicle;
use App\Repositories\TaskReservationRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\PendingTaskRepository;
use Illuminate\Support\Facades\Auth;

class RequestRepository {

    public function __construct(
        TaskReservationRepository $taskReservationRepository,
        PendingTaskRepository $pendingTaskRepository,
        ReservationRepository $reservationRepository,
        UserRepository $userRepository,
        VehicleRepository $vehicleRepository)
    {
        $this->taskReservationRepository = $taskReservationRepository;
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->reservationRepository = $reservationRepository;
        $this->userRepository = $userRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function create($request){
        $array_request = [];
        $vehicles = $request->json()->get('vehicles');
        $request_active = false;
        foreach($vehicles as $vehicle){
            $request_vehicle = new RequestVehicle();
            $vehicle_request_active = RequestVehicle::where('vehicle_id', $vehicle['vehicle_id'])
                                            ->where('state_request_id', 1)
                                            ->get();
            if(count($vehicle_request_active) > 0){
                $request_active = true;
            } else {
                $request_vehicle->vehicle_id = $vehicle['vehicle_id'];
                $request_vehicle->state_request_id = 1;
                $request_vehicle->customer_id = $request->json()->get('customer_id');
                $request_vehicle->type_request_id = $vehicle['type_request_id'];
                $request_vehicle->datetime_request = date('Y-m-d H:i:s');
                $request_vehicle->save();
                if($vehicle['type_request_id'] == 2){
                    $this->taskReservationRepository->create($request_vehicle->id, $request->json()->get('tasks'), $vehicle['vehicle_id']);
                    //Estado comercial cambia a solicitado para reserva
                    $this->vehicleRepository->updateTradeState($vehicle['vehicle_id'], 6);
                    //Creamos la reserva con active 0
                    $this->reservationRepository->create($request_vehicle['id'], $vehicle['vehicle_id'], $request->json()->get('reservation_time'), $request->json()->get('planned_reservation'), $request->json()->get('campa_id'), 0);
                }
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


    public function getById($id){
        return RequestVehicle::where('id', $id)
                        ->first();
    }


    public function update($request, $id){
        $request_vehicle = RequestVehicle::where('id', $id)
                            ->first();
        if($request->json()->get('vehicle_id')) $request_vehicle->vehicle_id = $request->get('vehicle_id');
        if($request->json()->get('customer_id')) $request_vehicle->customer_id = $request->get('customer_id');
        if($request->json()->get('state_request_id')) $request_vehicle->state_request_id = $request->get('state_request_id');
        if($request->json()->get('type_request_id')) $request_vehicle->type_request_id = $request->get('type_request_id');
        $request_vehicle->updated_at = date('Y-m-d H:i:s');
        $request_vehicle->save();
        if($request->json()->get('type_request_id') == 2){
            $this->reservationRepository->create($request_vehicle['id'], $request_vehicle['vehicle_id'], $request->json()->get('reservation_time'), $request->json()->get('planned_reservation'), $request->json()->get('campa_id'));
            //Cambia a estado comercial reservado
            $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 2);
        }
        return $request_vehicle;
    }


    public function vehiclesRequestedDefleet($request){
        return RequestVehicle::with(['vehicle.state','vehicle.category','vehicle.campa','state_request','type_request'])
                            ->whereHas('vehicle', function(Builder $builder) use ($request){
                                return $builder->where('campa_id', $request->json()->get('campa_id'));
                            })
                            ->where('type_request_id', 1)
                            ->where('state_request_id', 1)
                            ->get();
    }

    public function vehiclesRequestedReserve($request){
        return RequestVehicle::with(['vehicle.state','vehicle.category','vehicle.campa','state_request','type_request', 'customer','reservation'])
                            ->whereHas('vehicle', function(Builder $builder) use ($request){
                                return $builder->where('campa_id', $request->json()->get('campa_id'));
                            })
                            ->where('type_request_id', 2)
                            ->where('state_request_id', 1)
                            ->get();
    }

    public function confirmedRequest($request){
        $request_vehicle = RequestVehicle::where('id', $request->json()->get('request_id'))
                                    ->first();
        $request_vehicle->state_request_id = 2;
        $request_vehicle->datetime_approved = date('Y-m-d H:i:s');
        $request_vehicle->save();
        if($request_vehicle['type_request_id'] == 2){
            //Cambio de estado comercial a reservado
            $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 2);
            //Marcamos la reserva como ejecutada con el active 1
            $this->reservationRepository->changeStateReservation($request_vehicle['id'], 1);
            //Se crean las tareas solicitadas al momento de la reserva
            return $this->pendingTaskRepository->createPendingTaskFromReservation($request_vehicle['vehicle_id'], $request_vehicle['id']);
        }
        $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 3);
        return [
            'message' => 'Ok'
        ];
    }

    public function getConfirmedRequest($request){
        return RequestVehicle::with(['type_request','state_request','vehicle.state','vehicle.campa','vehicle.category'])
                            ->whereHas('vehicle', function (Builder $builder) use($request){
                                return $builder->where('campa_id', $request->json()->get('campa_id'));
                            })
                            ->where('type_request_id', $request->json()->get('type_request_id'))
                            ->where('state_request_id', 2)
                            ->get();
    }

    public function declineRequest($request){
        $request_vehicle = RequestVehicle::where('id', $request->json()->get('request_id'))
                                    ->first();
                                    //Ponemos el vehículo disponible
        $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 1);
        $request_vehicle->state_request_id = 3;
        $request_vehicle->save();
        //Eliminamos reservation
        $this->reervationRepository->deleteReservation($request);
        return RequestVehicle::with(['state_request'])
                        ->where('id', $request->json()->get('request_id'))
                        ->first();
    }

    public function getRequestDefleetApp(){
        $user = $this->userRepository->getById(Auth::id());
        return RequestVehicle::with(['vehicle.category','type_request'])
                            ->whereHas('vehicle', function (Builder $builder) use($user){
                                return $builder->where('campa_id', $user->campa_id);
                            })
                            ->where('type_request_id', 1)
                            ->where('state_request_id', 1)
                            ->get();

    }

    public function getRequestReserveApp(){
        $user = $this->userRepository->getById(Auth::id());
        return RequestVehicle::with(['vehicle.category','type_request'])
                            ->whereHas('vehicle', function (Builder $builder) use($user){
                                return $builder->where('campa_id', $user->campa_id);
                            })
                            ->where('type_request_id', 2)
                            ->where('state_request_id', 1)
                            ->get();

    }

}
