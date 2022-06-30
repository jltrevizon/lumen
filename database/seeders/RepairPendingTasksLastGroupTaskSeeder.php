<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\StatePendingTask;
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
        $pending_tasks = PendingTask::where('created_from_checklist', 1)
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('group_task_id NOT IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
            ->where('approved', 1)
            ->where(function ($query) {
                $query->where('state_pending_task_id', '<>', StatePendingTask::FINISHED)
                    ->orWhereNull('state_pending_task_id');
            })
            ->get();
        foreach ($pending_tasks as $key => $pending_task) {
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
            $pending_task->save();
            Log::debug($value);
        }
    }
}
