<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getReservationActive(Request $request){
        return $this->reservationRepository->getReservationActive($request);
    }

    public function getReservationActiveByCampa(Request $request){
        return $this->reservationRepository->getReservationActiveByCampa($request);
    }

    public function update(Request $request){
        return $this->reservationRepository->update($request);
    }

    public function getReservationsByVehicle(Request $request){
        return $this->reservationRepository->getReservationsByVehicle($request);
    }

    public function vehicleWithoutOrder(Request $request){
        return $this->reservationRepository->vehicleWithoutOrder($request);
    }

    public function vehicleWithoutContract(Request $request){
        return $this->reservationRepository->vehicleWithoutContract($request);
    }

}