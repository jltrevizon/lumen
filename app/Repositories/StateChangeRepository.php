<?php

namespace App\Repositories;

use App\Models\PendingTask;
use App\Models\SubStateChangeHistory;
use App\Models\StateChange;
use App\Models\SubState;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;

class StateChangeRepository extends Repository
{

    public function updateSubStateVehicle($vehicle, $param_sub_state_id = null)
    {
        $vehicle = Vehicle::find($vehicle->id);
        $sub_state_id = $vehicle->sub_state_id;
        if (!is_null($vehicle) && $sub_state_id !== SubState::SOLICITUD_DEFLEET && $sub_state_id !== SubState::WORKSHOP_EXTERNAL && $sub_state_id !== SubState::TRANSIT) {
            if (is_null($vehicle->lastGroupTask)) {
                $sub_state_id = null;
            } else {
                $approvedPendingTasks = $vehicle->lastGroupTask->approvedPendingTasks;
                $count = count($approvedPendingTasks);
                if ($count === 0) {
                    if ($sub_state_id != SubState::ALQUILADO) {
                        $sub_state_id = SubState::CAMPA;
                    }
                } else {
                    $pendingTask = $approvedPendingTasks[0];
                    $sub_state_id = $pendingTask->task->sub_state_id;
                    if ($sub_state_id === SubState::ALQUILADO) {
                        $sub_state_id = SubState::ALQUILADO;
                        $pendingTask->state_pending_task_id = StatePendingTask::FINISHED;
                        $pendingTask->save();
                    } else if (!$vehicle->lastGroupTask->approved && !$vehicle->lastGroupTask->approved_available) {
                        $sub_state_id = SubState::CHECK;
                    }
                }
            }
        } else if ($sub_state_id == SubState::SOLICITUD_DEFLEET && !is_null($vehicle->lastGroupTask)) {
            $approvedPendingTasks = $vehicle->lastGroupTask->approvedPendingTasks;
            $count = count($approvedPendingTasks);
            Log::debug([
                'bug' => $sub_state_id,
                'Bug2' => $param_sub_state_id,
                'count' => $count
            ]);
            if ($count > 0) {
                foreach ($approvedPendingTasks as $key => $pendingTask) {
                    if ($param_sub_state_id === SubState::ALQUILADO) {
                        $pendingTask->state_pending_task_id = StatePendingTask::FINISHED;
                        $pendingTask->save();
                    }
                }
                if ($param_sub_state_id === SubState::ALQUILADO) {
                    $reception = $pendingTask->reception;
                    if ($reception && $vehicle->type_model_order_id) {
                        $reception->type_model_order_id = $vehicle->type_model_order_id;
                        $reception->save();
                    }
                }
            }
        }

        if (!is_null($vehicle->lastGroupTask)) {
            $currentPendingTask = null;
            $lastPendingTask = null;
            $approvedPendingTasks = $vehicle->lastGroupTask->approvedPendingTasks;
            $count = count($approvedPendingTasks);
            if ($count > 0) {
                if ($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET) {
                    $pendingTask = $vehicle->lastGroupTask->lastTaskWithState;
                    if (!is_null($pendingTask)) {
                        $pendingTask->last_change_state = $vehicle->lastGroupTask->lastChangeState?->last_change_state;
                        $pendingTask->last_change_sub_state = $vehicle->lastGroupTask->lastChangeSubState?->last_change_sub_state;

                        if ($vehicle->subState?->state_id != $pendingTask->task->subState->state_id || is_null($pendingTask->last_change_state)) {
                            $pendingTask->last_change_state = Carbon::now();
                        }

                        if ($vehicle->sub_state_id != $pendingTask->task->sub_state_id || is_null($pendingTask->last_change_sub_state)) {
                            $pendingTask->last_change_sub_state = Carbon::now();
                        }

                        $pendingTask->save();
                    }
                }
                $currentPendingTask = $approvedPendingTasks[$count > 1 ? 1 : 0];
                $lastPendingTask =  $approvedPendingTasks[0];
                $this->createOrUpdate($vehicle, $lastPendingTask, $currentPendingTask);
            }
        } else {
            Log::debug('Bug: vehicle ' . $vehicle->id . ' Sin grupo de tareas');
        }

        if ($sub_state_id != $vehicle->sub_state_id) {
            $vehicle->last_change_sub_state = Carbon::now();
        }

        $state_id = SubState::find($sub_state_id)->state_id;
        if ($state_id != $vehicle->sub_state->state_id) {
            $pendingTask->last_change_state = Carbon::now();
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
                'group_task_id' => $currentPendingTask?->group_task_id,
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



    public function store($vehicleId, $subStateId)
    {
        $subStateChangeHistory = SubStateChangeHistory::where('vehicle_id', $vehicleId)
            ->orderBy('id', 'DESC')
            ->first();
        if ($subStateChangeHistory && $subStateChangeHistory->sub_state_id != $subStateId) {
            SubStateChangeHistory::create([
                'vehicle_id' => $vehicleId,
                'sub_state_id' => $subStateId
            ]);
        }
    }
}
