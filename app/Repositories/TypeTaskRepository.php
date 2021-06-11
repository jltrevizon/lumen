<?php

namespace App\Repositories;

use App\Models\TypeTask;
use Exception;

class TypeTaskRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return TypeTask::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $type_task = new TypeTask();
            $type_task->name = $request->get('name');
            $type_task->save();
            return $type_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $type_task = TypeTask::where('id', $id)
                        ->first();
            if(isset($request['name'])) $type_task->name = $request->get('name');
            $type_task->updated_at = date('Y-m-d H:i:s');
            $type_task->save();
            return $type_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            TypeTask::where('id', $id)
                ->delete();
            return [
                'message' => 'Type task deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
