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
use Carbon\Carbon;

class DeliveryVehicleRepository extends Repository
{

    public function __construct(
        SquareRepository $squareRepository,
        GroupTaskRepository $groupTaskRepository,
    ) {
        $this->squareRepository = $squareRepository;
        $this->groupTaskRepository = $groupTaskRepository;
    }

    public function index($request)
    {
        return DeliveryVehicle::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderBy('delivery_note_id', 'DESC')
            ->paginate($request->input('per_page'));
    }

    public function createDeliveryVehicles($vehicleId, $data, $deliveryNoteId, $count)
    {
        $user = User::with('campas')
            ->findOrFail(Auth::id());
        $vehicle = Vehicle::findOrFail($vehicleId);
        $groupTaskId = $vehicle->lastReception?->group_task_id ?? null;
        if (!$groupTaskId) {
            $groupTaskId = $vehicle->lastReception?->group_task_id;
        }
        DeliveryVehicle::create([
            'vehicle_id' => $vehicleId,
            'campa_id' => $user->campas[0]->id,
            'delivery_note_id' => $deliveryNoteId,
            'data_delivery' => json_encode($data),
            'delivery_by' => $user->name
        ]);
        PendingTask::updateOrCreate([
            'vehicle_id' => $vehicleId,
            'reception_id' => $vehicle->lastReception->id ?? null,
            'task_id' => Task::TOALQUILADO,
            'group_task_id' => $groupTaskId,
        ], [
            'state_pending_task_id' => StatePendingTask::PENDING,
            'user_id' => Auth::id(),
            'user_start_id' => Auth::id(),
            'user_end_id' => Auth::id(),
            'order' => 1,
            'approved' => true,
            'datetime_pending' => Carbon::now()->addSeconds($count * 1),
            'datetime_start' => Carbon::now()->addSeconds($count * 2),
            'datetime_finish' =>  Carbon::now()->addSeconds($count * 3),
            'campa_id' => $vehicle->campa_id
        ]);
        if ($vehicle->lastReception) {
            $vehicle->lastReception->finished = true;
            $vehicle->lastReception->save();
        }
    }

    public function delete($id)
    {
        $deliveryVehicle = DeliveryVehicle::findOrFail($id);
        $vehicle = Vehicle::findOrFail($deliveryVehicle->vehicle_id);
        $vehicle->campa_id = $deliveryVehicle->campa_id;

        $vehicle->sub_state_id = SubState::CAMPA;
        $vehicle->save();

        $deliveryVehicle->delete();
        return $deliveryVehicle;
    }
}
