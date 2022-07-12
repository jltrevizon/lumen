<?php

namespace App\Repositories\Invarat;

use App\Models\Order;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Repositories\Repository;
use App\Repositories\StateChangeRepository;

class InvaratOrderRepository extends Repository {

    public function __construct(
        InvaratWorkshopRepository $invaratWorkshopRepository,
        InvaratVehicleRepository $invaratVehicleRepository,
        InvaratPendingTaskRepository $invaratPendingTaskRepository,
        StateChangeRepository $stateChangeRepository,
    )
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
        $this->invaratVehicleRepository = $invaratVehicleRepository;
        $this->invaratPendingTaskRepository = $invaratPendingTaskRepository;
        $this->stateChangeRepository = $stateChangeRepository;
    }

    public function createOrder($request){
        $workshop = $this->invaratWorkshopRepository->createWorkshop($request->input('workshop'));
        $vehicle = $this->invaratVehicleRepository->createVehicle($request);
        $this->invaratPendingTaskRepository->create($vehicle['id']);
        $order = new Order();
        $order->vehicle_id = $vehicle['id'];
        $order->workshop_id = $workshop['workshop']['id'];
        $order->state_id = State::PENDING_TEST_DINAMIC_INITIAL;
        $order->id_gsp = $request['id_gsp'];
        $order->save();
        return Order::with(['workshop','vehicle.pendingTasks' => function ($query) {
                    return $query->whereNull('datetime_finish');
                }])
                ->where('vehicle_id', $vehicle['id'])
                ->first();
    }

    public function orderFilter($request){
        return Order::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->paginate($request->input('per_page'));
    }

}
