<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReservationController extends Controller
{
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getReservationActive(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationActive($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getReservationActiveByCampa(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationActiveByCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request){
        return $this->updateDataResponse($this->reservationRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getReservationsByVehicle(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationsByVehicle($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleWithoutOrder(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->vehicleWithoutOrder($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleWithoutContract(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->vehicleWithoutContract($request), HttpFoundationResponse::HTTP_OK);
    }

}
