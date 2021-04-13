<?php

namespace App\Repositories;
use App\Models\GroupTask;

class GroupTaskRepository {

    public function createWithVehicleId($vehicle_id){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicle_id;
        $group_task->save();
        return $group_task;
    }

}
