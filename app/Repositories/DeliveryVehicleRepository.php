<?php

namespace App\Repositories;

use App\Models\DeliveryVehicle;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class DeliveryVehicleRepository extends Repository {

    public function __construct(
        SquareRepository $squareRepository,
        GroupTaskRepository $groupTaskRepository
        )
    {
        $this->squareRepository = $squareRepository;
        $this->groupTaskRepository = $groupTaskRepository;
    }

    public function index($request){
        return DeliveryVehicle::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderBy('delivery_note_id', 'DESC')
            ->paginate($request->input('per_page'));
    }

    public function createDeliveryVehicles($vehicleId, $data, $deliveryNoteId){
        $this->squareRepository->freeSquare($vehicleId);
        $user = User::with('campas')
            ->findOrFail(Auth::id());
        $vehicle = Vehicle::findOrFail($vehicleId);
        $hasLastGroupTask = $vehicle->lastGroupTask->id ?? null;
        if(!$hasLastGroupTask) {
            $hasLastGroupTask = $this->groupTaskRepository->createGroupTaskApprovedByVehicle($vehicleId);
            $hasLastGroupTask = $hasLastGroupTask->id;
        }
        $lastGroupTask = $hasLastGroupTask;
        DeliveryVehicle::create([
            'vehicle_id' => $vehicleId,
            'campa_id' => $user->campas[0]->id,
            'delivery_note_id' => $deliveryNoteId,
            'data_delivery' => json_encode($data)
        ]);
        PendingTask::create([
            'vehicle_id' => $vehicleId,
            'reception_id' => $vehicle->lastReception->id ?? null,
            'task_id' => Task::TOALQUILADO,
            'state_pending_task_id' => StatePendingTask::FINISHED,
            'user_start_id' => Auth::id(),
            'user_end_id' => Auth::id(),
            'group_task_id'=> $lastGroupTask,
            'order' => 101,
            'approved' => true,
            'datetime_pending' => date('Y-m-d H:i:s'),
            'datetime_start' => date('Y-m-d H:i:s'),
            'datetime_end' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id){    
        $deliveryVehicle = DeliveryVehicle::findOrFail($id);
        $vehicle = Vehicle::findOrFail($deliveryVehicle->vehicle_id);
        $vehicle->campa_id = $deliveryVehicle->campa_id;
        $vehicle->save();
        $this->updateSubStateVehicle($deliveryVehicle->vehicle_id, SubState::CAMPA);
        $deliveryVehicle->delete();
        return $deliveryVehicle;
    }

    public function updateSubStateVehicle($vehicleId, $subState){
        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->sub_state_id = $subState;
        $vehicle->save();
    }

}
