<?php

namespace App\Repositories;

use App\Models\DeliveryVehicle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeliveryVehicleRepository extends Repository {

    public function __construct()
    {

    }

    public function index($request){
        return DeliveryVehicle::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function createDeliveryVehicles($vehicleId, $data){
        DeliveryVehicle::create([
            'vehicle_id' => $vehicleId,
            'data_delivery' => json_encode($data)
        ]);
    }

}
