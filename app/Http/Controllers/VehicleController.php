<?php

namespace App\Http\Controllers;

use App\Models\DefleetVariable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    public function getAll(){
        return Vehicle::with(['campa'])
                    ->get();
    }

    public function getById($id){
        return $this->vehicleRepository->getById($id);
    }

    public function create(Request $request){
        return $this->vehicleRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->vehicleRepository->update($request, $id);
    }

    public function verifyPlate(Request $request){
        return $this->vehicleRepository->verifyPlate($request);
    }

    public function vehicleDefleet(Request $request){
        return $this->vehicleRepository->vehicleDefleet($request);
    }

    public function delete($id){
        return $this->vehicleRepository->delete($id);
    }

    public function updateGeolocation($request){
        return $this->vehicleRepository->updateGeolocation($request);
    }

    public function createFromExcel(Request $request){
        return $this->vehicleRepository->createFromExcel($request);
    }

    public function getVehiclesReadyToDeliveryCampa(Request $request){
        return $this->vehicleRepository->getVehiclesReadyToDeliveryCampa($request);
    }

    public function getVehiclesReadyToDeliveryCompany(Request $request){
        return $this->vehicleRepository->getVehiclesReadyToDeliveryCompany($request);
    }

    public function getVehiclesWithReservationWithoutOrderCampa(Request $request){
        return $this->vehicleRepository->getVehiclesWithReservationWithoutOrderCampa($request);
    }

    public function getVehiclesWithReservationWithoutContractCampa(Request $request){
        return $this->vehicleRepository->getVehiclesWithReservationWithoutContractCampa($request);
    }

    public function getVehiclesWithReservationWithoutContractCompany(Request $request){
        return $this->vehicleRepository->getVehiclesWithReservationWithoutContractCompany($request);
    }

    public function filterVehicle(Request $request){
        return $this->vehicleRepository->filterVehicle($request);
    }

    public function vehicleReserved(){
        return $this->vehicleRepository->vehicleReserved();
    }
}
