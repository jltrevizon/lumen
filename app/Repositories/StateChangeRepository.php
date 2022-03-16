<?php

namespace App\Repositories;

use App\Models\StateChange;

class StateChangeRepository extends Repository {

    public function createOrUpdate($vehicleId, $lastPendingTask, $currentPendingTask){
        $stateChange = StateChange::where('vehicle_id', $vehicleId)
            ->where('sub_state_id', $lastPendingTask->task->sub_state_id)
            ->whereNull('datetime_finish_sub_state')
            ->orderBy('id','desc')
            ->first();
        if($stateChange && $lastPendingTask->sub_state_id != $currentPendingTask->sub_state_id){
            $stateChange->update([
                'datetime_finish_sub_state' => date('Ym-d H:i:s')
            ]);
        } else {
            StateChange::create([
                'vehicle_id' => $vehicleId,
                'group_task_id' => $currentPendingTask->group_task_id,
                'sub_state_id' => $currentPendingTask->task->sub_state_id,
            ]);
        }

    }

}
