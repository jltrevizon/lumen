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

    public function getByCampaWithoutReserve(Request $request){
        return $this->vehicleRepository->getByCampaWithoutReserve($request);
    }

    public function getByCompany(Request $request){
        return $this->vehicleRepository->getByCompany($request);
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

    public function vehiclesDefleeted(){
        return $this->vehicleRepository->vehiclesDefleeted();
    }

    public function vehiclesReserved(){
        return $this->vehicleRepository->vehiclesReserved();
    }

    public function getAllByCompany(Request $request){
        return $this->vehicleRepository->getAllByCompany($request);
    }

    public function getAllByCampa(Request $request){
        return $this->vehicleRepository->getAllByCampa($request);
    }

    public function createFromExcel(Request $request){
        return $this->vehicleRepository->createFromExcel($request);
    }

    public function getVehiclesAvailableReserveByCampa(Request $request){
        return $this->vehicleRepository->getVehiclesAvailableReserveByCampa($request);
    }

    public function getVehiclesAvailableReserveByCompany(Request $request){
        return $this->vehicleRepository->getVehiclesAvailableReserveByCompany($request);
    }

    public function vehiclesRequestReserveByCampa(Request $request){
        return $this->vehicleRepository->vehiclesRequestReserveByCampa($request);
    }

    public function vehiclesRequestReserveByCompany(Request $request){
        return $this->vehicleRepository->vehiclesRequestReserveByCompany($request);
    }

    public function VehiclesReserveByCompany(Request $request){
        return $this->vehicleRepository->VehiclesReserveByCompany($request);
    }

    public function vehiclesReservedByCampa(Request $request){
        return $this->vehicleRepository->vehiclesReservedByCampa($request);
    }

    public function vehiclesReservedByCompany(Request $request){
        return $this->vehicleRepository->vehiclesReservedByCompany($request);
    }

    public function vehiclesByStateCampa(Request $request){
        return $this->vehicleRepository->vehiclesByStateCampa($request);
    }

    public function vehiclesByStateCompany(Request $request){
        return $this->vehicleRepository->vehiclesByStateCompany($request);
    }

}
