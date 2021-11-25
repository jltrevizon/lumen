<?php

namespace App\Repositories;

use App\Models\DeliveryVehicle;
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
