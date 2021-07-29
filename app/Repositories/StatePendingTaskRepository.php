<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\StatePendingTask;
use Exception;

class StatePendingTaskRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return ['state_pending_task' => StatePendingTask::findOrFail($id)];
    }

    public function create($request){
        $state_pending_task = StatePendingTask::create($request->all());
        $state_pending_task->save();
        return $state_pending_task;
    }

    public function update($request, $id){
        $state_pending_task = StatePendingTask::findOrFail($id);
        $state_pending_task->update($request->all());
        return ['state_pending_task' => $state_pending_task];
    }

    public function delete($id){
        StatePendingTask::where('id', $id)
            ->delete();
        return [ 'message' => 'State pending task deleted' ];
    }
}
