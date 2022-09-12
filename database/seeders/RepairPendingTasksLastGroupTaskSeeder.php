<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\Role;
use App\Models\StatePendingTask;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RepairPendingTasksLastGroupTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pending_tasks = PendingTask::whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('group_task_id NOT IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
            ->where('approved', 1)
            ->where(function ($query) {
                $query->where('state_pending_task_id', '<>', StatePendingTask::FINISHED)
                    ->orWhereNull('state_pending_task_id');
            })
            ->get();
        Log::debug('BUG');
        Log::debug(count($pending_tasks));
        $user = User::where('role_id', Role::CONTROL)
            ->first();
        foreach ($pending_tasks as $key => $pending_task) {
            if ($pending_task->vehicle->lastReception) {
                if ($pending_task->vehicle->sub_state_id === 10) {
                   $this->finishTask($pending_task, $user);
                } else {
                    $value = [
                        'id' => $pending_task->id,
                        'group_task_id' => $pending_task->group_task_id,
                        'last_group_task_id' => $pending_task->vehicle->lastGroupTask->id,
                        'reception_id' => $pending_task->reception_id,
                        'last_reception_id' => $pending_task->vehicle->lastReception->id,
                        'vehicle_id' => $pending_task->vehicle_id,
                        'order' => count($pending_task->vehicle->lastGroupTask->approvedPendingTasks) + 1
                    ];
                    $pending_task->group_task_id = $value['last_group_task_id'];
                    $pending_task->reception_id = $value['last_reception_id'];
                    $pending_task->order = $value['order'];
                    if ($value['order'] == 1 && !$pending_task->state_pending_task_id && count($pending_task->vehicle->lastGroupTask->approvedPendingTasks) === 0) {
                        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                    }
                    if (count($pending_task->vehicle->lastGroupTask->approvedPendingTasks) > 0) {
                        $pending_task->state_pending_task_id = null;
                    }
                    Log::debug($pending_task->id);
                    $pending_task->save();
                }
            } else {
                $pending_task->approved = 0;
                $pending_task->save();
                Log::debug('VEHICLE WITHOUT RECEPTION');
            }
        }

        $pending_tasks = PendingTask::whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            // ->whereRaw('group_task_id NOT IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
            ->where('approved', 1)
            ->where(function ($query) {
                $query->where('state_pending_task_id', '<>', StatePendingTask::FINISHED)
                    ->orWhereNull('state_pending_task_id');
            })
            ->whereHas('vehicle', function (Builder $builder) {
                return $builder->where('sub_state_id', 10);
            })
            ->get();
        Log::debug('BUG ENTREGADO');
        Log::debug(count($pending_tasks));
        foreach ($pending_tasks as $key => $pending_task) {
            Log::debug($pending_task->vehicle->id);
            $this->finishTask($pending_task, $user);
        }
    }

    private function finishTask($pending_task, $user) {
        $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
        $pending_task->order = -1;
        if (is_null($pending_task->user_id)) {
            $pending_task->user_start_id = $user->id;
        }
        if (is_null($pending_task->user_id)) {
            $pending_task->user_start_id = $user->id;
        }
        if (is_null($pending_task->user_end_id)) {
            $pending_task->user_end_id = $user->id;
        }
        $pending_task->user_end_id = $user->id;
        $pending_task->datetime_finish = date('Y-m-d H:i:s');
        if (is_null($pending_task->datetime_start)) {
            $pending_task->datetime_start = date('Y-m-d H:i:s');
        }
        $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);
        $pending_task->save();
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
}
