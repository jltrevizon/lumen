<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Repositories\GroupTaskRepository;
use App\Repositories\Repository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\Auth;

class InvaratPendingTaskRepository extends Repository {

    public function __construct(
        TaskRepository $taskRepository,
        VehicleRepository $vehicleRepository,
        GroupTaskRepository $groupTaskRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->groupTaskRepository = $groupTaskRepository;
    }

    public function create($vehicleId){
        $tasks = $this->taskRepository->getByCompany(Company::INVARAT);
        $reception = $this->vehicleRepository->newReception($vehicleId);
        $groupTask = $reception->groupTask;
        $order = 1;
        foreach($tasks as $task){
            $pendingTask = new PendingTask();
            $pendingTask->vehicle_id = $vehicleId;
            $pendingTask->user_id = Auth::id();
            $pendingTask->task_id = $task['id'];
            $pendingTask->approved = true;
            if($order == 1) {
                $pendingTask->state_pending_task_id = StatePendingTask::PENDING;
                $pendingTask->datetime_pending = date('Y-m-d H:i:s');
            }
            $pendingTask->group_task_id = $groupTask['id'];
            $pendingTask->duration = $task['duration'];
            $pendingTask->order = $order;
            $pendingTask->save();
            $order++;
        }
        $this->stateChangeRepository->updateSubStateVehicle($groupTask->vehicle);
    }

}
