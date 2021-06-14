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
        try {
            return response()->json(['state_pending_task' => StatePendingTask::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $state_pending_task = new StatePendingTask();
            $state_pending_task->name = $request->input('name');
            $state_pending_task->save();
            return $state_pending_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $state_pending_task = StatePendingTask::findOrFail($id);
            $state_pending_task->update($request->all());
            return response()->json(['state_pending_task' => $state_pending_task], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            StatePendingTask::where('id', $id)
                ->delete();
            return [
                'message' => 'State pending task deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
