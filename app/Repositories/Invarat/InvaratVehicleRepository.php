<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Repositories\BrandRepository;
use App\Repositories\VehicleModelRepository;
use App\Repositories\VehicleRepository;

class InvaratVehicleRepository {

    public function __construct(
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository,
        VehicleRepository $vehicleRepository
        )
    {
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function createVehicle($request){
        $vehicleExist = $this->vehicleRepository->getByPlate($request);
        if($vehicleExist) return $vehicleExist;
        $brand = $this->brandRepository->getByNameFromExcel($request->input('brand'));
        $vehicleModel = $this->vehicleModelRepository->getByNameFromExcel($brand->id, $request->input('vehicle_model'));
        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->sub_state_id = SubState::PENDING_TEST_DINAMIC_INITIAL;
        $vehicle->vehicle_model_id= $vehicleModel->id;
        $vehicle->save();
        return $vehicle;
    }

}
