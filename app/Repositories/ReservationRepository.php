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
                                    return $builder->where('company_id', $request->input('company_id'));
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
                                    return $builder->where('campa_id', $request->input('campa_id'));
                                })
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request){
        try {
            $reservation = Reservation::findOrFail($request->input('reservation_id'))
                                    ->first();
            $reservation->update($request->all());
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
                            ->where('id', $request->input('reservation_id'))
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getReservationsByVehicle($request){
        try {
            return Reservation::where('vehicle_id', $request->input('vehicle_id'))
                                ->where('contract', null)
                                ->orderBy('id', 'desc')
                                ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function deleteReservation($request){
        try {
            Reservation::where('request_id', $request->input('request_id'))
                    ->delete();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function vehicleWithoutOrder($request){
        try {
            return Reservation::with(['request.state_request','vehicle.category','vehicle.subState.state'])
                            ->where('vehicle_id', $request->input('vehicle_id'))
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
                            ->where('vehicle_id', $request->input('vehicle_id'))
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
