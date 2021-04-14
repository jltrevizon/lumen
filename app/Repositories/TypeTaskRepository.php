<?php

namespace App\Repositories;

use App\Models\TypeTask;

class TypeTaskRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return TypeTask::where('id', $id)
                    ->first();
    }

    public function create($request){
        $type_task = new TypeTask();
        $type_task->name = $request->get('name');
        $type_task->save();
        return $type_task;
    }

    public function update($request, $id){
        $type_task = TypeTask::where('id', $id)
                    ->first();
        if(isset($request['name'])) $type_task->name = $request->get('name');
        $type_task->updated_at = date('Y-m-d H:i:s');
        $type_task->save();
        return $type_task;
    }

    public function delete($id){
        TypeTask::where('id', $id)
            ->delete();
        return [
            'message' => 'Type task deleted'
        ];
    }
}
