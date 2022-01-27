<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Models\GroupTask;
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
            $groupTask = null;
            if ($request->input('group_task_id')) {
                $groupTask = GroupTask::findOrFail($request->input('group_task_id'));
            } else {
                $groupTask = $this->groupTaskRepository->createGroupTaskApproved($request);                
            } 

           if($request->input('state_pending_task_id') == StatePendingTask::PENDING){
                $this->createPendingTask($request->input('vehicle_id'), $request->input('tasks'), $groupTask->id);
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
                }
                $update_pending_task->order = $order;
                $update_pending_task->save();
                $order++;
            }
            $pending_task->datetime_pending = date("Y-m-d H:i:s");
            $pending_task->save();


        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), ], 400);
        }
    }

    private function createPendingTask($vehicleId, $tasks, $groupTaskId){
        PendingTask::where('vehicle_id', $vehicleId)
            ->where('group_task_id', $groupTaskId)
            ->where('state_pending_task_id', StatePendingTask::PENDING)
            ->update([
                'state_pending_task_id' => null
            ]);
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = true;
            if($task['task_order'] == 1) {
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['task_order'];
            $pending_task->user_id = Auth::id();
            $pending_task->save();
            $this->vehicleRepository->updateSubState($pending_task->vehicle_id, null);
            /*
            if($task['task_order'] == 1) {   
                $vehicle = $pending_task->vehicle;
                $vehicle->sub_state_id = $pending_task->task->sub_state_id;
                $vehicle->save();
            }*/
        }
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
