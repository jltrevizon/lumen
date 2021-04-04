<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingTask;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\TaskController;

class PendingTaskController extends Controller
{
    public function __construct(GroupTaskController $groupTaskController, TaskController $taskController)
    {
        $this->groupTaskController = $groupTaskController;
        $this->taskController = $taskController;
    }

    public function getAll(){
        return PendingTask::all();
    }

    public function getById($id){
        return PendingTask::where('id', $id)
                        ->first();
    }

    public function create(Request $request){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $request->get('vehicle_id');
        $pending_task->task_id = $request->get('task_id');
        if(isset($request['state_pending_task_id'])) $pending_task->state_pending_task_id = $request->get('state_pending_task_id');
        if(isset($request['incidence_id'])) $pending_task->incidence_id = $request->get('incidence_id');
        $pending_task->group_task_id = $request->get('group_task_id');
        $pending_task->duration = $request->get('duration');
        $pending_task->order = $request->get('order');
        $pending_task->save();
        return $pending_task;
    }

    public function update(Request $request, $id){
        $pending_task = PendingTask::where('id', $id)
                            ->first();
        if(isset($request['vehicle_id'])) $pending_task->vehicle_id = $request->get('vehicle_id');
        if(isset($request['task_id'])) $pending_task->task_id = $request->get('task_id');
        if(isset($request['state_pending_task_id'])) $pending_task->state_pending_task_id = $request->get('state_pending_task_id');
        if(isset($request['group_task_id'])) $pending_task->group_task_id = $request->get('group_task_id');
        if(isset($request['incidence_id'])) $pending_task->incidence_id = $request->get('incidence_id');
        if(isset($request['duration'])) $pending_task->duration = $request->get('duration');
        if(isset($request['order'])) $pending_task->order = $request->get('order');
        $pending_task->updated_at = date('Y-m-d H:i:s');
        $pending_task->save();
        return $pending_task;
    }

    public function delete($id){
        PendingTask::where('id', $id)
                ->delete();
        return [
            'message' => 'Pending task deleted'
        ];
    }

    public function createFromArray(Request $request){
        $groupTask = $this->groupTaskController->create($request);
        foreach($request->get('tasks') as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $request->get('vehicle_id');
            $taskDescription = $this->taskController->getById($task['task_id']);
            $pending_task->task_id = $task['task_id'];
            if($task['task_order'] == 1){
                $pending_task->state_pending_task_id = 1;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $groupTask->id;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['task_order'];
            $pending_task->save();
        }
        return [
            'message' => 'OK'
        ];
    }

    public function getPendingTask(){
        return PendingTask::with(['vehicle','state_pending_task'])
                        ->where('state_pending_task_id', 1)
                        ->get();
    }

    public function startPendingTask(Request $request){
        $pending_task = PendingTask::where('id', $request->get('pending_task_id'))
                                ->first();
        if($pending_task->state_pending_task_id == 1){
            $pending_task->state_pending_task_id = 2;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->save();
            return PendingTask::with(['state_pending_task'])
                        ->where('id', $request->get('pending_task_id'))
                        ->first();
        } else {
            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }
    }

    public function finishPendingTask(Request $request){
        $pending_task = PendingTask::where('id', $request->get('pending_task_id'))
                                ->first();
        if($pending_task->state_pending_task_id == 2){
            $pending_task->state_pending_task_id = 3;
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->save();
            $pending_task_next = PendingTask::where('group_task_id', $pending_task->group_task_id)
                                    ->where('order','>',$pending_task->order)
                                    ->orderBy('order', 'asc')
                                    ->first();
            if($pending_task_next){
                $pending_task_next->state_pending_task_id = 1;
                $pending_task_next->datetime_pending= date('Y-m-d H:i:s');
                $pending_task_next->save();
                return PendingTask::with(['state_pending_task'])
                                ->where('id', $pending_task_next->id)
                                ->first();
            } else {
                return [
                    "status" => "OK",
                    "message" => "No hay más tareas"
                ];
            }
        } else {
            return [
                'message' => 'La tarea no está en estado iniciada'
            ];
        }
    }
}
