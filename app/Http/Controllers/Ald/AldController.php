<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Models\GroupTask;
use App\Models\SubState;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskRepository;
use App\Repositories\VehicleRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;


class AldController extends Controller
{

    public function __construct(
        TaskRepository $taskRepository,
        GroupTaskRepository $groupTaskRepository,
        VehicleRepository $vehicleRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function unapprovedTask(Request $request){
        try {
            return Vehicle::with($this->getWiths($request->with))
            ->whereHas('lastUnapprovedGroupTask')
            ->whereHas('campa', function (Builder $builder) {
                return $builder->where('company_id', Company::ALD);
            })
            ->filter($request->all())
            ->paginate($request->input('per_page'));
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function approvedTask(Request $request){
        try {
            return Vehicle::with($this->getWiths($request->with))
                    ->whereHas('groupTasks', function (Builder $builder) {
                        return $builder->where('approved', true);
                    })
                    ->whereHas('campa', function (Builder $builder) {
                        return $builder->where('company_id', Company::ALD);
                    })
                    ->filter($request->all())
                    ->paginate($request->input('per_page'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createTaskVehiclesAvalible(Request $request){
        try {
            $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
            if(!$vehicle->lastReception){
                return $this->failResponse(['message' => 'Reception not found'], HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
            $groupTask = null;
            if ($request->input('group_task_id')) {
                $groupTask = GroupTask::findOrFail($request->input('group_task_id'));
            } else {
                $groupTask = $this->groupTaskRepository->createGroupTaskApproved($request);                
            } 

           if($request->input('state_pending_task_id') == StatePendingTask::PENDING){
                $this->createPendingTask($groupTask, $request->input('vehicle_id'), $request->input('tasks'), $groupTask->id, $vehicle);
            } else if($request->input('state_pending_task_id') == StatePendingTask::FINISHED){
                $this->createFinishedTask($request->input('vehicle_id'), $request->input('tasks'), $groupTask->id);
            }

            $is_pending_task = false;

            $lastGroupTask = GroupTask::find($groupTask->id);
            $pending_tasks = $lastGroupTask->pendingTasks;
            $order = 1;
            foreach($pending_tasks as $pending_task)
            {
                $update_pending_task = PendingTask::find($pending_task['id']);
                if ($update_pending_task->state_pending_task_id === StatePendingTask::PENDING) {
                    $is_pending_task = true;
                }
                if (is_null($update_pending_task->state_pending_task_id) && !$is_pending_task) {
                    $is_pending_task = true;
                    $update_pending_task->state_pending_task_id = StatePendingTask::PENDING;
                    $update_pending_task->datetime_pending = date('Y-m-d H:i:s');
                }
                $update_pending_task->order = $order;
                $update_pending_task->save();
                $order++;
            }
            $pending_task->datetime_pending = date("Y-m-d H:i:s");
            $pending_task->save();
            return $this->createDataResponse(['data' => $pending_task], HttpFoundationResponse::HTTP_CREATED);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), ], 400);
        }
    }

    private function createPendingTask($groupTask, $vehicleId, $tasks, $groupTaskId, $vehicle){
        $tasksApproved = 0;
        if ($groupTask->approvedPendingTasks) {
            $tasksApproved = count($groupTask->approvedPendingTasks);
        }
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $pending_task->reception_id = $vehicle->lastReception->id;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = true;
            if($tasksApproved == 0) {
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task->order = 1;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            } else {
                $pending_task->order = $tasksApproved + 1;
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->user_id = Auth::id();
            $pending_task->save();
        }
        $vehicleWithOldPendingTask = $this->vehicleRepository->pendingOrInProgress($vehicleId);
        $vehicle = $this->vehicleRepository->pendingOrInProgress($vehicleId);
        if($vehicle && $vehicle->sub_state_id == null){
            $vehicle->sub_state_id = SubState::CAMPA;
            $vehicle->save();
        }
        $this->vehicleRepository->updateSubState($vehicleId, $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], $vehicle?->lastGroupTask?->pendingTasks[0]);
    }

    private function createFinishedTask($vehicleId, $tasks, $groupTaskId){
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = true;
            $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
            $pending_task->datetime_pending = date('Y-m-d H:i:s');
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['task_order'];
            $pending_task->save();
        }
    }

}
