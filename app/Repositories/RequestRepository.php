<?php

namespace App\Repositories;
use App\Models\Request as RequestVehicle;
use App\Models\State;
use App\Models\StateRequest;
use App\Models\TradeState;
use App\Models\TypeRequest;
use App\Models\TypeReservation;
use App\Repositories\TaskReservationRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\PendingTaskRepository;
use Exception;
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
        $vehicles = $request->input('vehicles');
        $request_active = false;
        foreach($vehicles as $vehicle){
            $request_vehicle = new RequestVehicle();
            $vehicle_request_active = RequestVehicle::where('vehicle_id', $vehicle['vehicle_id'])
                                            ->where('state_request_id', StateRequest::REQUESTED)
                                            ->get();
            if(count($vehicle_request_active) > 0){
                $request_active = true;
            } else {
                $request_vehicle->vehicle_id = $vehicle['vehicle_id'];
                $request_vehicle->state_request_id = StateRequest::REQUESTED;
                $request_vehicle->customer_id = $request->input('customer_id');
                $request_vehicle->type_request_id = $vehicle['type_request_id'];
                $request_vehicle->datetime_request = date('Y-m-d H:i:s');
                $request_vehicle->save();
                if($vehicle['type_request_id'] == TypeRequest::RESERVATION){
                    $this->taskReservationRepository->create($request_vehicle->id, $request->input('tasks'), $vehicle['vehicle_id']);
                    $tasks = $this->taskReservationRepository->getByRequest($request_vehicle->id);
                    if(count($tasks) > 0) {
                        $this->vehicleRepository->updateTradeState($vehicle['vehicle_id'], TradeState::PRE_RESERVED);
                        $this->vehicleRepository->updateState($vehicle['vehicle_id'], State::NOT_AVAILABLE);
                    } else {
                        $this->vehicleRepository->updateTradeState($vehicle['vehicle_id'], TradeState::RESERVED);
                        $this->vehicleRepository->updateState($vehicle['vehicle_id'], State::NOT_AVAILABLE);
                    }
                    $this->reservationRepository->create($request_vehicle['id'], $vehicle['vehicle_id'], $request->input('reservation_time'), $request->input('planned_reservation'), $request->input('campa_id'), 1, $request->input('type_reservation_id'));
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
        try {
            return RequestVehicle::findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }


    public function update($request, $id){
        try {
            $request_vehicle = RequestVehicle::findOrFail($id);
            $request_vehicle->update($request->all());
            if($request->input('type_request_id') == 2){
                $this->reservationRepository->create($request_vehicle['id'], $request_vehicle['vehicle_id'], $request->input('reservation_time'), $request->input('planned_reservation'), $request->input('campa_id'));
                $tasks = $this->taskReservationRepository->getByRequest($request_vehicle->id);
                if(count($tasks) > 0) {
                    //Si hay tareas pasamos el vehículo al estado pre-reservado
                    $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 2);
                } else {
                    //Si no hay tareas pasamos el vehículo al estado reservado
                    $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], 1);
                }
            }
            return $request_vehicle;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }


    public function vehiclesRequestedDefleet($request){
        try {
            return RequestVehicle::with(['vehicle.state','vehicle.category','vehicle.campa','state_request','type_request'])
                                ->whereHas('vehicle', function(Builder $builder) use ($request){
                                    return $builder->where('campa_id', $request->input('campa_id'));
                                })
                                ->where('type_request_id', 1)
                                ->where('state_request_id', 1)
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehiclesRequestedReserve($request){
        try {
            return RequestVehicle::with(['vehicle.state','vehicle.category','vehicle.campa','state_request','type_request', 'customer','reservation'])
                                ->whereHas('vehicle', function(Builder $builder) use ($request){
                                    return $builder->where('campa_id', $request->input('campa_id'));
                                })
                                ->where('type_request_id', 2)
                                ->where('state_request_id', 1)
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function confirmedRequest($request){
        $request_vehicle = RequestVehicle::findOrFail($request->input('request_id'));
        $request_vehicle->state_request_id = StateRequest::APPROVED;
        $request_vehicle->datetime_approved = date('Y-m-d H:i:s');
        $request_vehicle->save();
        if($request_vehicle['type_request_id'] == TypeRequest::RESERVATION){
            $reservation = $this->reservationRepository->getByRequestId($request_vehicle['id']);
            if($reservation['type_reservation_id'] == TypeReservation::NORMAL){
                $tasks = $this->taskReservationRepository->getByRequest($request_vehicle->id);
            if(count($tasks) > 0) {
                $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::PRE_RESERVED);
            } else {
                $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::RESERVED);
            }
            } else {
                $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::RESERVED_PRE_DELIVERY);
            }
            $this->reservationRepository->changeStateReservation($request_vehicle['id'], true);
            return $this->pendingTaskRepository->createPendingTaskFromReservation($request_vehicle['vehicle_id'], $request_vehicle['id']);
        }
        $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::REQUEST_DEFLEET);
        $this->vehicleRepository->updateState($request_vehicle['vehicle_id'], State::PENDING_SALE_VO);
        return [ 'message' => 'Ok' ];
    }

    public function getConfirmedRequest($request){
        try {
            return RequestVehicle::with(['type_request','state_request','vehicle.state','vehicle.campa','vehicle.category'])
                                ->whereHas('vehicle', function (Builder $builder) use($request){
                                    return $builder->where('campa_id', $request->input('campa_id'));
                                })
                                ->where('type_request_id', $request->input('type_request_id'))
                                ->where('state_request_id', 2)
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function declineRequest($request){
        try {
            $request_vehicle = RequestVehicle::where('id', $request->input('request_id'))
                                        ->first();
            //Ponemos el vehículo disponible
            $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], null);
            $request_vehicle->state_request_id = 3;
            $request_vehicle->save();
            //Eliminamos reservation
            $this->reservationRepository->deleteReservation($request);
            return RequestVehicle::with(['state_request'])
                            ->where('id', $request->input('request_id'))
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getRequestDefleetApp(){
        try {
            $user = $this->userRepository->getById(Auth::id());
            return RequestVehicle::with(['vehicle.category','type_request'])
                                ->whereHas('vehicle', function (Builder $builder) use($user){
                                    return $builder->where('campa_id', $user->campa_id);
                                })
                                ->where('type_request_id', 1)
                                ->where('state_request_id', 1)
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getRequestReserveApp(){
        try {
            $user = $this->userRepository->getById(Auth::id());
            return RequestVehicle::with(['vehicle.category','type_request'])
                                ->whereHas('vehicle', function (Builder $builder) use($user){
                                    return $builder->where('campa_id', $user->campa_id);
                                })
                                ->where('type_request_id', 2)
                                ->where('state_request_id', 1)
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
