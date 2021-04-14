<?php

namespace App\Repositories;

use App\Models\Reservation;

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

}
