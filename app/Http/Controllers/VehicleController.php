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
}
