<?php

namespace App\Repositories;

use App\Models\TypeTask;
use Exception;

class TypeTaskRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return ['type_task' => TypeTask::findOrFail($id)];
    }

    public function create($request){
        $type_task = TypeTask::create($request->all());
        $type_task->save();
        return $type_task;
    }

    public function update($request, $id){
        $type_task = TypeTask::findOrFail($id);
        $type_task->update($request->all());
        return ['type_task' => $type_task];
    }

    public function delete($id){
        TypeTask::where('id', $id)
            ->delete();
        return [ 'message' => 'Type task deleted' ];
    }
}
