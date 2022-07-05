<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\Role;
use App\Models\State;
use App\Models\SubState;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ReapirDatesPendingTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('role_id', Role::CONTROL)
            ->first();
        $pendingTasks = PendingTask::with(['vehicle.subState.state', 'task.subState.state'])
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('group_task_id IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
            ->whereIn('state_pending_task_id', [1, 2])
            ->whereHas('vehicle', function(Builder $builder) {
                return $builder->whereNull('last_change_state')->orWhereNull('last_change_sub_state');
            })
            ->get();

        Log::debug(count($pendingTasks));

        foreach ($pendingTasks as $key => $value) {
            if (is_null($value->user_id)) {
                $value->user_id = $user->id;
            }
            $count = count($value->vehicle->lastGroupTask->approvedPendingTasks);
            if ($value->vehicle->last_change_state) {
                $value->vehicle->last_change_sub_state = $value->vehicle->last_change_state;
            } else {
                if ($count == 0) {
                    if ($value->vehicle->subState->state_id != State::AVAILABLE) {
                        $value->vehicle->last_change_state = $value->vehicle->lastReception->created_at;
                        $value->vehicle->last_change_sub_state = $value->vehicle->lastReception->created_at;
                    } else {
                        $value->vehicle->last_change_state = $value->vehicle->lastReception->created_at;
                        $value->vehicle->last_change_sub_state = $value->vehicle->lastReception->created_at;
                    }
                    $value->vehicle->sub_state_id = SubState::CAMPA;
                } else {
                    if (!is_null($value->datetime_pending)) {
                        if (is_null($value->user_start_id)) {
                            $value->user_start_id = $user->id;
                        }
                        if ($value->vehicle->subState->state_id != $value->task->subState?->state_id) {
                            $value->vehicle->last_change_state = $value->datetime_pending;
                        }
                        if ($value->vehicle->sub_state_id != $value->task->sub_state_id) {
                            $value->vehicle->last_change_sub_state = $value->datetime_pending;
                        }
                        $value->vehicle->sub_state_id = $value->task->sub_state_id;
                    } else if (!is_null($value->datetime_start)) {
                        if (is_null($value->user_start_id)) {
                            $value->user_start_id = $user->id;
                        }
                        if ($value->vehicle->subState->state_id != $value->task->subState?->state_id) {
                            $value->vehicle->last_change_state = $value->datetime_start;
                        }
                        if ($value->vehicle->sub_state_id != $value->task->sub_state_id) {
                            $value->vehicle->last_change_sub_state = $value->datetime_datetime_startpending;
                        }
                        $value->vehicle->sub_state_id = $value->task->sub_state_id;
                    } else {
                        if (is_null($value->user_start_id)) {
                            $value->user_start_id = $user->id;
                        }
                        if ($value->state_pending_task_id === 1) {
                            $value->datetime_pending = date('Y-m-d H:i:s');
                        }
                        if ($value->state_pending_task_id === 2) {
                            $value->datetime_start = date('Y-m-d H:i:s');
                        }
                        if ($value->vehicle->subState->state_id != $value->task->subState?->state_id) {
                            $value->vehicle->last_change_state = $value->state_pending_task_id === 1 ? $value->datetime_pending : $value->datetime_start;
                        }
                        if ($value->vehicle->sub_state_id != $value->task->sub_state_id) {
                            $value->vehicle->last_change_sub_state = $value->state_pending_task_id === 1 ? $value->datetime_pending : $value->datetime_start;
                        }
                        $value->vehicle->sub_state_id = $value->task->sub_state_id;
                    }

                    if (is_null($value->vehicle->last_change_state) && $count > 0) {
                        if ($value->vehicle->lastReception) {
                            $value->vehicle->last_change_state = $value->vehicle->lastReception->created_at;
                            $value->vehicle->last_change_sub_state = $value->vehicle->lastReception->created_at;
                        } else {
                            $reception = new Reception();
                            $reception->campa_id = $user->campas->pluck('id')->toArray()[0];
                            $reception->vehicle_id = $value->vehicle->id;
                            $reception->finished = false;
                            $reception->has_accessories = false;
                            $reception->save();
                            $value->reception_id = $reception->id;
                            $value->vehicle->last_change_state = $reception->created_at;
                            $value->vehicle->last_change_sub_state = $reception->created_at;
                        }
                    }
                }
            }
            $value->vehicle->save();
            $value->save();
        }
    }
}
