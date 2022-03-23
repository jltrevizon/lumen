<?php

namespace App\Repositories;

use App\Models\StateChange;
use App\Models\Vehicle;
use DateTime;

class StateChangeRepository extends Repository {

    public function createOrUpdate($vehicleId, $lastPendingTask, $currentPendingTask){
        $vehicle = Vehicle::findOrFail($vehicleId);
        $stateChange = StateChange::where('vehicle_id', $vehicleId)
            ->where('sub_state_id', $lastPendingTask?->task?->sub_state_id)
            ->whereNull('datetime_finish_sub_state')
            ->orderBy('id','desc')
            ->first();
        if($stateChange && $stateChange->sub_state_id != $currentPendingTask?->task?->sub_state_id){
            $stateChange->update([
                'datetime_finish_sub_state' => date('Y-m-d H:i:s'),
                'total_time' => $stateChange->total_time + $this->diffDateTimes($stateChange->created_at)
            ]);
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null, 
                'vehicle_id' => $vehicleId,
                'group_task_id' => $currentPendingTask->group_task_id,
                'sub_state_id' => $currentPendingTask->task->sub_state_id,
            ]);
        } 
        if(!$stateChange){
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null, 
                'vehicle_id' => $vehicleId,
                'group_task_id' => $currentPendingTask->group_task_id,
                'sub_state_id' => $currentPendingTask->task->sub_state_id,
            ]);
        }

    }

    private function diffDateTimes($datetime){
        $datetime1 = new DateTime($datetime);
        $diference = date_diff($datetime1, new DateTime());
        $minutes = $diference->days * 24 * 60;
        $minutes += $diference->h * 60;
        $minutes += $diference->i;
        return $minutes;
    }

}
