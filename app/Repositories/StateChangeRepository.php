<?php

namespace App\Repositories;

use App\Models\SubStateChangeHistory;
use App\Models\StateChange;
use App\Models\SubState;
use App\Models\State;
use Carbon\Carbon;
use DateTime;

class StateChangeRepository extends Repository
{

    public function updateSubStateVehicle($vehicle)
    {
        $sub_state_id = $vehicle->sub_state_id;
        if (!is_null($vehicle) && $sub_state_id !== SubState::SOLICITUD_DEFLEET) {
            if (is_null($vehicle->lastGroupTask)) {
                $sub_state_id = null;
            } else if (!$vehicle->lastGroupTask->approved && !$vehicle->lastGroupTask->approved_available) {
                $sub_state_id = SubState::CHECK;
            } else {
                $approvedPendingTasks = $vehicle->lastGroupTask->approvedPendingTasks;
                $count = count($approvedPendingTasks);
                if ($count === 0) {
                    if ($vehicle->subState?->state_id != State::AVAILABLE) {
                        $vehicle->last_change_state = Carbon::now();
                        $vehicle->last_change_sub_state = Carbon::now();
                    }
                    $sub_state_id = SubState::CAMPA;
                } else if ($count === 1 && $approvedPendingTasks[0]->task->sub_state_id === SubState::CHECK) {
                    $sub_state_id = SubState::CHECK;
                } else {
                    $sub_state_id = $vehicle->lastGroupTask->approvedPendingTasks[0]->task->sub_state_id;
                }
                if ($count > 0 && $sub_state_id !== 8) {
                    if ($vehicle->subState?->state_id != $vehicle->lastGroupTask->approvedPendingTasks[0]->task->subState->state_id) {
                        $vehicle->last_change_state = Carbon::now();
                    }
                    if ($vehicle->sub_state_id != $vehicle->lastGroupTask->approvedPendingTasks[0]->task->sub_state_id) {
                        $vehicle->last_change_sub_state = Carbon::now();
                    }
                }
                $currentPendingTask = null;
                $lastPendingTask = null;
                $count = count($vehicle->lastGroupTask->approvedPendingTasks);
                if ($count > 0) {
                    $currentPendingTask = $vehicle->lastGroupTask->approvedPendingTasks[$count > 1 ? 1 : 0];
                    $lastPendingTask = $vehicle->lastGroupTask->approvedPendingTasks[0];
                }
                $this->createOrUpdate($vehicle, $lastPendingTask, $currentPendingTask);
            }
        }
        $vehicle->sub_state_id = $sub_state_id;
        $vehicle->save();
        $this->store($vehicle->id, $vehicle->sub_state_id);
        return $vehicle;
    }


    public function createOrUpdate($vehicle, $lastPendingTask, $currentPendingTask)
    {
        $stateChange = StateChange::where('vehicle_id', $vehicle->id)
            ->where('sub_state_id', $lastPendingTask?->task?->sub_state_id)
            ->whereNull('datetime_finish_sub_state')
            ->orderBy('id', 'desc')
            ->first();
        if ($stateChange && $currentPendingTask != null && $stateChange->sub_state_id != $currentPendingTask?->task?->sub_state_id) {
            $stateChange->update([
                'datetime_finish_sub_state' => date('Y-m-d H:i:s'),
                'total_time' => $stateChange->total_time + $this->diffDateTimes($stateChange->created_at)
            ]);
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null,
                'vehicle_id' => $vehicle->id,
                'pending_task_id' => $currentPendingTask->id,
                'group_task_id' => $currentPendingTask->group_task_id,
                'sub_state_id' => $currentPendingTask == null ? SubState::CAMPA : $currentPendingTask->task->sub_state_id,
            ]);
            return;
        }
        if ($currentPendingTask == null) {
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null,
                'vehicle_id' => $vehicle->id,
                'pending_task_id' => null,
                'group_task_id' => null,
                'sub_state_id' => SubState::CAMPA,
            ]);
            return;
        }
        if (!$stateChange && $currentPendingTask != null) {
            StateChange::create([
                'campa_id' => $vehicle->campa_id ?? null,
                'vehicle_id' => $vehicle->id,
                'pending_task_id' => $currentPendingTask->id ?? null,
                'group_task_id' => $currentPendingTask->group_task_id ?? null,
                'sub_state_id' => $currentPendingTask->task->sub_state_id ?? null,
            ]);
            return;
        }
    }

    private function diffDateTimes($datetime)
    {
        $datetime1 = new DateTime($datetime);
        $diference = date_diff($datetime1, new DateTime());
        $minutes = $diference->days * 24 * 60;
        $minutes += $diference->h * 60;
        $minutes += $diference->i;
        return $minutes;
    }



    public function store($vehicleId, $subStateId){
        $subStateChangeHistory = SubStateChangeHistory::where('vehicle_id', $vehicleId)
            ->orderBy('id', 'DESC')
            ->first();
        if($subStateChangeHistory && $subStateChangeHistory->sub_state_id != $subStateId){
            SubStateChangeHistory::create([
                'vehicle_id' => $vehicleId,
                'sub_state_id' => $subStateId
            ]);
        }
        
    }

}
