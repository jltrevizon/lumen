<?php

namespace App\Repositories;
use App\Models\Task;
use Exception;

class TaskRepository extends Repository {

    public function getAll($request){
        return Task::with($this->getWiths($request->with))
                    ->get();
    }

    public function getById($id){
        return Task::findOrFail($id);
    }

    public function create($request){
        $task = Task::create($request->all());
        $task->save();
        return $task;
    }

    public function update($request, $id){
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return ['task' => $task];
    }

    public function delete($id){
        Task::where('id', $id)
            ->delete();
        return [ 'message' => 'Task deleted' ];
    }
}
