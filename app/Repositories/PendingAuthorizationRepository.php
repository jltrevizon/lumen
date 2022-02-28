<?php

namespace App\Repositories;

use App\Models\PendingAuthorization;
use App\Models\PendingTask;
use App\Models\StateAuthorization;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingAuthorizationRepository extends Repository {

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index($request){
        return PendingAuthorization::with($this->getWiths($request->with))
            ->filter($request->all())
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
        $pendingAuthorization = PendingAuthorization::where('id', $request->input('pending_authorization_id'))->first();
        if($pendingAuthorization && $request->input('state_authorization_id') == StateAuthorization::APPROVED){
            $this->approvedPendingAuthorization($pendingAuthorization->vehicle_id, $pendingAuthorization->task_id);
            $pendingAuthorization->state_authorization_id = StateAuthorization::APPROVED;
            $pendingAuthorization->save();
        }
        return $pendingAuthorization;
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
            $groupTask = $this->groupTaskRepository->createGroupTaskApprovedByVehicle($vehicleId);
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