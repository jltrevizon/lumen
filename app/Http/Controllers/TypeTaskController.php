<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeTask;

class TypeTaskController extends Controller
{
    public function getAll(){
        return TypeTask::all();
    }

    public function getById($id){
        return TypeTask::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $type_task = new TypeTask();
        $type_task->name = $request->get('name');
        $type_task->save();
        return $type_task;
    }

    public function update(Request $request, $id){
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
