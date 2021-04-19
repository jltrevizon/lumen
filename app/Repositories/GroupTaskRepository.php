<?php

namespace App\Repositories;
use App\Models\GroupTask;

class GroupTaskRepository {

    public function __construct()
    {

    }

    public function createWithVehicleId($vehicle_id){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicle_id;
        $group_task->save();
        return $group_task;
    }

    public function create($request){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->json()->get('vehicle_id');
        $group_task->save();
        return $group_task;
    }

    public function update($request, $id){
        $group_task = GroupTask::where('id', $id)
                        ->first();
        $group_task->vehicle_id = $request->json()->get('vehicle_id');
        $group_task->updated_at = date('Y-m-d H:i:s');
        $group_task->save();
        return $group_task;
    }

    public function getLastByVehicle($vehicle_id){
        return GroupTask::where('vehicle_id', $vehicle_id)
                        ->first();
    }
}
