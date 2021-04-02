<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTask;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupTaskController extends Controller
{
    public function getAll(){
        return GroupTask::all();
    }

    public function getById($id){
        return GroupTask::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->get('vehicle_id');
        $group_task->save();
        return $group_task;
    }

    public function update(Request $request, $id){
        $group_task = GroupTask::where('id', $id)
                        ->first();
        $group_task->vehicle_id = $request->get('vehicle_id');
        $group_task->updated_at = date('Y-m-d H:i:s');
        $group_task->save();
        return $group_task;
    }

    public function delete($id){
        GroupTask::where('id', $id)
            ->delete();

        return [
            'message' => 'Group task deleted'
        ];
    }
}
