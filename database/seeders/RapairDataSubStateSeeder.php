<?php

namespace Database\Seeders;

use App\Models\StatePendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RapairDataSubStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::debug('RapairDataSubStateSeeder');
        $vehicles = Vehicle::all();
        foreach ($vehicles as $key => $vehicle) {
            Log::debug($vehicle->id);
            if ($vehicle->lastGroupTask?->lastPendingTaskWithState?->id) {
                $pendingTask = $vehicle->lastGroupTask?->lastPendingTaskWithState;
                Log::debug($pendingTask?->id);
                if (is_null($pendingTask->last_change_state)) {
                    $last_change_state = null;
                    if ($pendingTask->state_pending_task_id === StatePendingTask::PENDING) {
                        $last_change_state = $pendingTask->datetime_pending;
                    }
                    if ($pendingTask->state_pending_task_id === StatePendingTask::IN_PROGRESS) {
                            $last_change_state = $pendingTask->datetime_start;
                    }
                    $pendingTask->last_change_state = $last_change_state;
                    $pendingTask->save();
                }

                if (is_null($pendingTask->last_change_sub_state)) {
                    $last_change_sub_state = null;
                    if ($pendingTask->state_pending_task_id === StatePendingTask::PENDING) {
                        $last_change_sub_state = $pendingTask->datetime_pending;
                    }
                    if ($pendingTask->state_pending_task_id === StatePendingTask::IN_PROGRESS) {
                            $last_change_sub_state = $pendingTask->datetime_start;
                    }
                    $pendingTask->last_change_sub_state = $last_change_sub_state;
                    $pendingTask->save();
                }
                

            }
        }
    }
}
