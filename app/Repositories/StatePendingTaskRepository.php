<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\StatePendingTask;

class StatePendingTaskRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return StatePendingTask::where('id', $id)
                    ->first();
    }

    public function create($request){
        $state_pending_task = new StatePendingTask();
        $state_pending_task->name = $request->get('name');
        $state_pending_task->save();
        return $state_pending_task;
    }

    public function update($request, $id){
        $state_pending_task = StatePendingTask::where('id', $id)
                    ->first();
        $state_pending_task->name = $request->get('name');
        $state_pending_task->updated_at = date('Y-m-d H:i:s');
        $state_pending_task->save();
        return $state_pending_task;
    }

    public function delete($id){
        StatePendingTask::where('id', $id)
            ->delete();
        return [
            'message' => 'State pending task deleted'
        ];
    }
}
