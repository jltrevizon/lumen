<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\Role;
use App\Models\User;
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
        ->get();

        Log::debug(count($pendingTasks));

        foreach ($pendingTasks as $key => $value) {
            if ($value->vehicle->last_change_state) {
             //   Log::debug(strtotime($value->vehicle->last_change_state));
            } else {
                // Log::debug('REGISTROS last_change_state NULOS');
                if (!is_null($value->datetime_pending)) {
                    // Log::debug($value->datetime_pending);
                } else if (!is_null($value->datetime_start)) {
                    // Log::debug($value->datetime_start);
                } else {
                    if (is_null($value->user_id)) {
                        $value->user_id = $user->id;
                    }
                    if ($value->state_pending_task_id === 1) {
                        $value->datetime_pending = date('Y-m-d H:i:s');
                    }
                    if ($value->state_pending_task_id === 2) {
                        $value->datetime_start = date('Y-m-d H:i:s');
                    }
                    if($value->vehicle->subState && $value->vehicle->subState->state_id != $value->task->subState?->state_id){
                        $value->vehicle->last_change_state = $value->state_pending_task_id === 1 ? $value->datetime_pending : $value->datetime_start;
                    }
                    if($value->vehicle->sub_state_id != $value->task->sub_state_id){
                        $value->vehicle->last_change_sub_state = $value->state_pending_task_id === 1 ? $value->datetime_pending : $value->datetime_start;
                    }
                    $value->vehicle->sub_state_id = $value->task->sub_state_id;
                    $value->save();
                }
            }
        }

    }
}
