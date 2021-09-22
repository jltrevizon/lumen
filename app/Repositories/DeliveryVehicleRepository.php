<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Models\DeliveryVehicle;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class DeliveryVehicleRepository {

    public function __construct()
    {

    }

    public function createDeliveryVehicles($vehicleId, $data){
        DeliveryVehicle::create([
            'vehicle_id' => $vehicleId,
            'data_delivery' => json_encode($data)
        ]);
    }

}
