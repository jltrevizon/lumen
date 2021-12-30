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
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AldController extends Controller
{

    public function __construct(
        TaskRepository $taskRepository,
        GroupTaskRepository $groupTaskRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->groupTaskRepository = $groupTaskRepository;
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

            $lastGroupTask = GroupTask::find($groupTask->id);
            $pending_tasks = $lastGroupTask->pendingTasks;
            $order = 1;
            foreach($pending_tasks as $pending_task)
            {
                $update_pending_task = PendingTask::where('id', $pending_task['id'])
                                            ->first();
                if($update_pending_task->state_pending_task_id != StatePendingTask::IN_PROGRESS && $update_pending_task->state_pending_task_id != StatePendingTask::FINISHED)
                {
                    $update_pending_task->state_pending_task_id = null;
                    $update_pending_task->datetime_pending = null;
                }
                $update_pending_task->order = $order;
                $update_pending_task->save();
                $order++;
            }
            $pending_task = PendingTask::where('vehicle_id', $request->input('vehicle_id'))
                            ->where(function ($query) {
                                return $query->where('state_pending_task_id', null)
                                        ->orWhere('state_pending_task_id', StatePendingTask::PENDING);
                            })
                            ->where('approved', true)
                            ->where('group_task_id',  $groupTask->id)
                            ->orderBy('order','asc')
                            ->first();
            $pending_task->state_pending_task_id = StatePendingTask::PENDING;
            $pending_task->datetime_pending = date("Y-m-d H:i:s");
            $pending_task->save();


        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), ], 400);
        }
    }

    private function createPendingTask($vehicleId, $tasks, $groupTaskId){
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = true;
            if($task['task_order'] == 1) {
                 if (!isset($task['without_state_pending_task'])) {
                    $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                }
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['task_order'];
            $pending_task->save();
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
