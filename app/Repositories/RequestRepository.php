<?php

namespace App\Repositories;
use App\Models\Request as RequestVehicle;
use App\Models\State;
use App\Models\StateRequest;
use App\Models\SubState;
use App\Models\TradeState;
use App\Models\TypeRequest;
use App\Models\TypeReservation;
use App\Repositories\TaskReservationRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\PendingTaskRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestRepository extends Repository {

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
                        $this->vehicleRepository->updateSubState($vehicle['vehicle_id'], SubState::CAMPA);
                    } else {
                        $this->vehicleRepository->updateTradeState($vehicle['vehicle_id'], TradeState::RESERVED);
                        $this->vehicleRepository->updateSubState($vehicle['vehicle_id'], SubState::NOT_AVAILABLE);
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
        return RequestVehicle::findOrFail($id);
    }


    public function update($request, $id){
        $request_vehicle = RequestVehicle::findOrFail($id);
        $request_vehicle->update($request->all());
        if($request->input('type_request_id') == TypeRequest::RESERVATION){
            $this->reservationRepository->create($request_vehicle['id'], $request_vehicle['vehicle_id'], $request->input('reservation_time'), $request->input('planned_reservation'), $request->input('campa_id'));
            $tasks = $this->taskReservationRepository->getByRequest($request_vehicle->id);
            if(count($tasks) > 0) {
                $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::PRE_RESERVED);
            } else {
                $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], TradeState::RESERVED);
            }
        }
        return $request_vehicle;
    }


    public function vehiclesRequestedDefleet($request){
        return RequestVehicle::with($this->getWiths($request->with))
                    ->byVehicleInCampa($request->input('campa_id'))
                    ->where('type_request_id', TypeRequest::DEFLEET)
                    ->where('state_request_id', StateRequest::REQUESTED)
                    ->get();
    }

    public function vehiclesRequestedReserve($request){
        return RequestVehicle::with($this->getWiths($request->with))
                    ->byVehicleInCampa($request->input('campa_id'))
                    ->where('type_request_id', TypeRequest::RESERVATION)
                    ->where('state_request_id', StateRequest::REQUESTED)
                    ->get();
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
        $this->vehicleRepository->updateSubState($request_vehicle['vehicle_id'], SubState::SOLICITUD_DEFLEET);
        return [ 'message' => 'Ok' ];
    }

    public function getConfirmedRequest($request){
        return RequestVehicle::with($this->getWiths($request->with))
                    ->byVehicleInCampa($request->input('campa_id'))
                    ->where('type_request_id', $request->input('type_request_id'))
                    ->where('state_request_id', StateRequest::APPROVED)
                    ->get();
    }

    public function declineRequest($request){
        $request_vehicle = RequestVehicle::findOrFail($request->input('request_id'));
        $this->vehicleRepository->updateTradeState($request_vehicle['vehicle_id'], null);
        $request_vehicle->state_request_id = StateRequest::DECLINED;
        $request_vehicle->save();
        $this->reservationRepository->deleteReservation($request);
        return RequestVehicle::with($this->getWiths($request->with))
                    ->findOrFail($request->input('request_id'));
    }

    public function getRequestDefleetApp($request){
        $user = $this->userRepository->getById($request, Auth::id());
        return RequestVehicle::with($this->getWiths($request->with))
                    ->byVehicleInCampa($user->campas->pluck('id')->toArray())
                    ->where('type_request_id', TypeRequest::DEFLEET)
                    ->where('state_request_id', StateRequest::REQUESTED)
                    ->get();
    }

    public function getRequestReserveApp($request){
        $user = $this->userRepository->getById($request, Auth::id());
        return RequestVehicle::with(['vehicle.category','type_request'])
                    ->byVehicleInCampa($user->campas->pluck('id')->toArray())
                    ->where('type_request_id', TypeRequest::RESERVATION)
                    ->where('state_request_id', StateRequest::REQUESTED)
                    ->get();
    }

}
