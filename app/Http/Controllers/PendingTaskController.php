<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingTask;

class PendingTaskController extends Controller
{
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
}
