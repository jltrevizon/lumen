<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class RepairAutomaticTaskReception extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Vehicle::all() as $vehicle) {
            if (!!$vehicle->lastReception &&  $vehicle->lastReception->receptionPendingTask()->count() == 0 &&
                $vehicle->lastReception->pendingTasks()->count() > 0) {
                $user_id = $vehicle->lastReception->pendingTasks[0]->user_id;
                $pending_task = new PendingTask();
                $pending_task->vehicle_id = $vehicle->id;
                $pending_task->reception_id = $vehicle->lastReception->id;
                $pending_task->campa_id = $vehicle->campa_id;
                $pending_task->task_id = Task::RECEPTION;
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->approved = 1;
                $pending_task->created_from_checklist = true;
                $pending_task->datetime_pending = $vehicle->lastReception->created_at;
                $pending_task->datetime_start = $vehicle->lastReception->created_at;
                $pending_task->datetime_finish = $vehicle->lastReception->created_at;
                $pending_task->user_start_id = $user_id;
                $pending_task->user_end_id = $user_id;
                $pending_task->user_start_id = $user_id;
                $pending_task->user_id = $user_id;
                $pending_task->created_at = $vehicle->lastReception->created_at;
                $pending_task->updated_at = $vehicle->lastReception->created_at;
                $pending_task->save();
            }
        }
    }
}
