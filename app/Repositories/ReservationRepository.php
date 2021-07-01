<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\TaskReservationRepository;
use App\Repositories\VehicleRepository;
use Exception;

class ReservationRepository {

    public function __construct(
        TaskReservationRepository $taskReservationRepository,
        VehicleRepository $vehicleRepository
    )
    {
        $this->taskReservationRepository = $taskReservationRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getByRequestId($request_id){
        try {
            return Reservation::where('request_id', $request_id)
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request_id, $vehicle_id, $reservation_time, $planned_reservation, $campa_id, $active, $reservation_type_id){
        try {
            $reservation = new Reservation();
            $reservation->request_id = $request_id;
            $reservation->vehicle_id = $vehicle_id;
            $reservation->reservation_time = $reservation_time;
            $reservation->planned_reservation = $planned_reservation;
            $reservation->campa_id = $campa_id;
            $reservation->active = $active;
            $reservation->type_reservation_id = $reservation_type_id;
            $reservation->save();
            return $reservation;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function changeStateReservation($request_vehicle, $active){
        try {
            $reservation = Reservation::where('request_id', $request_vehicle)
                                    ->first();
            $reservation->active = $active;
            $reservation->save();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getReservationActive($request){
        try {
            return Reservation::with(['vehicle.state','vehicle.category','request.type_request','request.state_request'])
                                ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                                    return $builder->where('company_id', $request->json()->get('company_id'));
                                })
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getReservationActiveByCampa($request){
        try {
            return Reservation::with(['vehicle.state','vehicle.category','request.type_request','request.state_request'])
                                ->whereHas('vehicle', function (Builder $builder) use($request){
                                    return $builder->where('campa_id', $request->json()->get('campa_id'));
                                })
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request){
        try {
            $reservation = Reservation::where('id', $request->json()->get('reservation_id'))
                                    ->first();
            if($request->json()->get('dni')) $reservation->dni = $request->json()->get('dni');
            if($request->json()->get('order')) $reservation->order = $request->json()->get('order');
            if($request->json()->get('contract')) $reservation->contract = $request->json()->get('contract');
            if($request->json()->get('actual_date')) $reservation->actual_date = $request->json()->get('actual_date');
            if($request->json()->get('contract')) $reservation->active = 0;
            if($request->json()->get('pickup_by_customer') == false || $request->json()->get('pickup_by_customer') == true) $reservation->pickup_by_customer = $request->json()->get('pickup_by_customer');
            if($request->json()->get('transport_id') == false || $request->json()->get('transport_id') != false) $reservation->transport_id = $request->json()->get('transport_id');
            $reservation->save();
            if($reservation->order != null && $reservation->contract != null){
                $task_reservation = $this->taskReservationRepository->getByRequest($reservation->request_id);
                if($reservation->type_reservation_id == 2){
                    //Si el tipo de reserva es pre-entrega el estado del vehículo pasa a reservado pre-entrega
                    $this->vehicleRepository->updateTradeState($reservation['vehicle_id'], 3);
                } else {
                    if(count($task_reservation) > 0){
                        //Si la reserva es normal el vehículo no tiene tareas pasa a reservado
                        $this->vehicleRepository->updateTradeState($reservation['vehicle_id'], 1);
                    } else {
                        //Si la reserva es normal el vehículo tiene tareas pasa a reservado pre-entrega
                        $this->vehicleRepository->updateTradeState($reservation['vehicle_id'], 2);
                    }
                }
            }
            return Reservation::with(['transport'])
                            ->where('id', $request->json()->get('reservation_id'))
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getReservationsByVehicle($request){
        try {
            return Reservation::where('vehicle_id', $request->json()->get('vehicle_id'))
                                ->where('contract', null)
                                ->orderBy('id', 'desc')
                                ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function deleteReservation($request){
        try {
            Reservation::where('request_id', $request->json()->get('request_id'))
                    ->delete();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleWithoutOrder($request){
        try {
            return Reservation::with(['request.state_request','vehicle.category','vehicle.subState.state'])
                            ->where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->where('order', null)
                            ->whereHas('request', function (Builder $builder) {
                                return $builder->where('state_request_id', 1);
                            })
                            ->orderBy('id','desc')
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleWithoutContract($request){
        try {
            return Reservation::with(['request.state_request','vehicle.category','vehicle.subState.state'])
                            ->where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->where('contract', null)
                            ->whereHas('request', function (Builder $builder) {
                                return $builder->where('state_request_id', 2);
                            })
                            ->orderBy('id','desc')
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
