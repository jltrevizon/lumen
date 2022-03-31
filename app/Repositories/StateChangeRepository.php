<?php

namespace App\Repositories;

use App\Models\StateChange;
use App\Models\SubState;
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
        if($stateChange && $currentPendingTask != null && $stateChange->sub_state_id != $currentPendingTask?->task?->sub_state_id){
            $stateChange->update([
                'datetime_finish_sub_state' => date('Y-m-d H:i:s'),
                'total_time' => $stateChange->total_time + $this->diffDateTimes($stateChange->created_at)
            ]);
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null, 
                'vehicle_id' => $vehicleId,
                'pending_task_id' => $currentPendingTask->id,
                'group_task_id' => $currentPendingTask->group_task_id,
                'sub_state_id' => $currentPendingTask == null ? SubState::CAMPA : $currentPendingTask->task->sub_state_id,
            ]);
            return;
        } 
        if($currentPendingTask == null){
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null, 
                'vehicle_id' => $vehicleId,
                'pending_task_id' => null,
                'group_task_id' => null,
                'sub_state_id' => SubState::CAMPA,
            ]);
            return;
        }
        if(!$stateChange && $currentPendingTask != null){
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null, 
                'vehicle_id' => $vehicleId,
                'pending_task_id' => $currentPendingTask->id ?? null,
                'group_task_id' => $currentPendingTask->group_task_id ?? null,
                'sub_state_id' => $currentPendingTask->task->sub_state_id ?? null,
            ]);
            return;
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
