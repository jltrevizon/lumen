<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    public function getAll(){
        return Task::all();
    }

    public function getById($id){
        return Task::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $task = new Task();
        $task->sub_state_id = $request->get('sub_state_id');
        $task->type_task_id = $request->get('type_task_id');
        $task->name = $request->get('name');
        $task->duration = $request->get('duration');
        $task->save();
        return $task;
    }

    public function update(Request $request, $id){
        $task = Task::where('id', $id)
                    ->first();
        if(isset($request['sub_state_id'])) $task->sub_state_id = $request->get('sub_state_id');
        if(isset($request['type_task_id'])) $task->type_task_id = $request->get('type_task_id');
        if(isset($request['name'])) $task->name = $request->get('name');
        if(isset($request['duration'])) $task->duration = $request->get('duration');
        $task->updated_at = date('Y-m-d H:i:s');
        $task->save();
        return $task;
    }

    public function delete($id){
        Task::where('id', $id)
            ->delete();
        return [
            'message' => 'Task deleted'
        ];
    }

    public function getTest(TaskRepository $taskRepository){
        return $taskRepository->getTestRepository();
    }
}
