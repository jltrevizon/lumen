<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\Vehicle;

class InvaratVehicleRepository {

    public function __construct()
    {

    }

    public function createVehicle($request){
        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->save();
        return $vehicle;
    }

}
