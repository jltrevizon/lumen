<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
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

    public function unapprovedTask(){
        try {
            return Vehicle::with(['lastUnapprovedGroupTask','vehicleModel.brand','campa','category','lastQuestionnaire'])
            ->whereHas('lastUnapprovedGroupTask')
            ->whereHas('campa', function (Builder $builder) {
                return $builder->where('company_id', Company::ALD);
            })
            ->paginate();
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
                    ->paginate();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createTaskVehiclesAvalible(Request $request){
        try {
            $groupTask = $this->groupTaskRepository->createGroupTaskApproved($request);
            if($request->input('state_pending_task_id') == StatePendingTask::PENDING){
                $this->createPendingTask($request->input('vehicle_id'), $request->input('tasks'), $groupTask->id);
            } else if($request->input('state_pending_task_id') == StatePendingTask::FINISHED){
                $this->createFinishedTask($request->input('vehicle_id'), $request->input('tasks'), $groupTask->id);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
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
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
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
