<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Repositories\BrandRepository;
use App\Repositories\VehicleModelRepository;

class InvaratVehicleRepository {

    public function __construct(
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository
        )
    {
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
    }

    public function createVehicle($request){

        $brand = $this->brandRepository->getByNameFromExcel($request->input('brand'));
        $vehicleModel = $this->vehicleModelRepository->getByNameFromExcel($brand->id, $request->input('vehicle_model'));
        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->sub_state_id = SubState::PENDING_TEST_DINAMIC;
        $vehicle->vehicle_model_id= $vehicleModel->id;
        $vehicle->save();
        return $vehicle;
    }

}
