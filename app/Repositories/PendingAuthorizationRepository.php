<?php

namespace App\Repositories;

use App\Models\PendingAuthorization;
use App\Models\PendingTask;
use App\Models\StateAuthorization;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class PendingAuthorizationRepository extends Repository {



    public function index($request){
        return PendingAuthorization::with($this->getWiths($request->with))
            ->get();
    }
    
    public function create($vehicleId, $taskId, $damageId){
        PendingAuthorization::create([
            'vehicle_id' => $vehicleId,
            'task_id' => $taskId,
            'damage_id' => $damageId,
            'state_authorization' => StateAuthorization::PENDING
        ]);
    }

    public function approvedAuthorization($request){
        $pendingAuthorization = PendingAuthorization::findOrFail($request->input('pending_authorization_id'));
        if($request->input('state_authorization_id') == StateAuthorization::APPROVED){
            $this->approvedPendingAuthorization($pendingAuthorization->vehicle_id, $pendingAuthorization->taskId);
        }
    }

    private function approvedPendingAuthorization($vehicleId, $taskId){
        $vehicle = Vehicle::findOrFail($vehicleId);
        $task = $this->taskRepository->getById([], $taskId);
        $groupTask = null;
        $totalPendingTaskActives = 0;
        if($vehicle->lastGroupTask){
            $totalPendingTaskActives = count($vehicle->lastGroupTask->allApprovedPendingTasks);
        }
        if($totalPendingTaskActives > 0) {
            $groupTask = $vehicle->lastGroupTask;
        }
        else {
            $groupTask = $this->groupTaskRepository->createWithVehicleId($vehicleId);
        };
        PendingTask::create([
            'vehicle_id' => $vehicleId,
            'task_id' => $taskId,
            'group_task_id' => $groupTask->id,
            'state_pending_task_id' => $totalPendingTaskActives > 0 ? null : StatePendingTask::PENDING,
            'duration' => $task->duration,
            'order' => $totalPendingTaskActives + 1,
            'approved' => true,
            'user_id' => Auth::id()
        ]);
    }

}