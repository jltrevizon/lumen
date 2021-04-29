<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;

class ReservationRepository {

    public function __construct()
    {

    }

    public function create($request_id, $vehicle_id, $reservation_time, $planned_reservation, $campa_id, $active){
        $reservation = new Reservation();
        $reservation->request_id = $request_id;
        $reservation->vehicle_id = $vehicle_id;
        $reservation->reservation_time = $reservation_time;
        $reservation->planned_reservation = $planned_reservation;
        $reservation->campa_id = $campa_id;
        $reservation->active = $active;
        $reservation->save();
        return $reservation;
    }

    public function changeStateReservation($request_vehicle, $active){
        $reservation = Reservation::where('request_id', $request_vehicle)
                                ->first();
        $reservation->active = $active;
        $reservation->save();
    }

    public function getReservationActive($request){
        return Reservation::with(['vehicle.state','vehicle.category','request.type_request','request.state_request'])
                            ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                                return $builder->where('company_id', $request->json()->get('company_id'));
                            })
                            ->get();

    }

    public function getReservationActiveByCampa($request){
        return Reservation::with(['vehicle.state','vehicle.category','request.type_request','request.state_request'])
                            ->whereHas('vehicle', function (Builder $builder) use($request){
                                return $builder->where('campa_id', $request->json()->get('campa_id'));
                            })
                            ->get();
    }

    public function update($request){
        $reservation = Reservation::where('id', $request->json()->get('reservation_id'))
                                ->first();
        if($request->json()->get('dni')) $reservation->dni = $request->json()->get('dni');
        if($request->json()->get('order')) $reservation->order = $request->json()->get('order');
        if($request->json()->get('contract')) $reservation->contract = $request->json()->get('contract');
        if($request->json()->get('actual_date')) $reservation->actual_date = $request->json()->get('actual_date');
        $reservation->save();
        return $reservation;

    }

    public function getReservationsByVehicle($request){
        return Reservation::where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->where('active', 0)
                            ->first();
    }

}
