<?php

namespace App\Repositories;
use App\Models\Task;
use Exception;

class TaskRepository {

    public function getById($id){
        try {
            $task = Task::with(['sub_state.state'])
                        ->findOrFail($id);
            return response()->json(['task' => $task], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $task = new Task();
            $task->sub_state_id = $request->input('sub_state_id');
            $task->type_task_id = $request->input('type_task_id');
            $task->name = $request->input('name');
            $task->duration = $request->input('duration');
            $task->save();
            return $task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $task = Task::findOrFail($id);
            $task->update($request->all());
            return response()->json(['task' => $task], 200);
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
