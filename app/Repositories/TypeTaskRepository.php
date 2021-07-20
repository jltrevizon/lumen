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
            return response()->json(['type_task' => TypeTask::findOrFail($id)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $type_task = TypeTask::create($request->all());
            $type_task->save();
            return $type_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $type_task = TypeTask::findOrFail($id);
            $type_task->update($request->all());
            return response()->json(['type_task' => $type_task], 200);
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
