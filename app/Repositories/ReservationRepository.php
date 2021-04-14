<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;

class ReservationRepository {

    public function __construct()
    {

    }

    public function create($request_id, $vehicle_id, $reservation_time){
        $reservation = new Reservation();
        $reservation->request_id = $request_id;
        $reservation->vehicle_id = $vehicle_id;
        $reservation->reservation_time = $reservation_time;
        $reservation->save();
        return $reservation;
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

}
