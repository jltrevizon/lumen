<?php

namespace App\Repositories;
use App\Models\GroupTask;
use Exception;

class GroupTaskRepository {

    public function __construct()
    {

    }

    public function createWithVehicleId($vehicle_id){
        try {
            $group_task = new GroupTask();
            $group_task->vehicle_id = $vehicle_id;
            $group_task->save();
            return $group_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $group_task = new GroupTask();
            $group_task->vehicle_id = $request->input('vehicle_id');
            $group_task->save();
            return $group_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $group_task = GroupTask::findOrFail($id);
            $group_task->update($request->all());
            return response()->json(['group_task' => $group_task], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getLastByVehicle($vehicle_id){
        try {
            return GroupTask::where('vehicle_id', $vehicle_id)
                            ->orderBy('id', 'desc')
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
