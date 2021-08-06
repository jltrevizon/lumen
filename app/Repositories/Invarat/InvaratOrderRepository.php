<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\Order;
use App\Models\Role;
use App\Models\State;
use App\Models\User;

class InvaratOrderRepository {

    public function __construct(
        InvaratWorkshopRepository $invaratWorkshopRepository,
        InvaratVehicleRepository $invaratVehicleRepository
    )
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
        $this->invaratVehicleRepository = $invaratVehicleRepository;
    }

    public function createOrder($request){
        $workshop = $this->invaratWorkshopRepository->createWorkshop($request->input('workshop'));
        $vehicle = $this->invaratVehicleRepository->createVehicle($request);
        $order = new Order();
        $order->vehicle_id = $vehicle['id'];
        $order->workshop_id = $workshop['workshop']['id'];
        $order->state_id = State::PENDING_TEST_DINAMIC;
        $order->id_gsp = $request['id_gsp'];
        $order->save();
        return $order;
    }

}
