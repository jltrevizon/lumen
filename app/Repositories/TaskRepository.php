<?php

namespace App\Repositories;
use App\Models\Task;
use Exception;

class TaskRepository {

    public function getById($id){
        try {
            return Task::with(['sub_state.state'])
                        ->where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $task = new Task();
            $task->sub_state_id = $request->json()->get('sub_state_id');
            $task->type_task_id = $request->json()->get('type_task_id');
            $task->name = $request->json()->get('name');
            $task->duration = $request->json()->get('duration');
            $task->save();
            return $task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $task = Task::where('id', $id)
                        ->first();
            if($request->json()->get('sub_state_id')) $task->sub_state_id = $request->get('sub_state_id');
            if($request->json()->get('type_task_id')) $task->type_task_id = $request->get('type_task_id');
            if($request->json()->get('name')) $task->name = $request->get('name');
            if($request->json()->get('name')) $task->duration = $request->get('duration');
            $task->updated_at = date('Y-m-d H:i:s');
            $task->save();
            return $task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Task::where('id', $id)
                ->delete();
            return [
                'message' => 'Task deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
