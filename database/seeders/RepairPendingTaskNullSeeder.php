<?php

namespace Database\Seeders;

use App\Models\StatePendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RepairPendingTaskNullSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::debug('Begin Repair');
        $vehicles = Vehicle::all();
        foreach ($vehicles as $key => $value) {
            $approvedPendingTasks = $value->approvedPendingTasks;
            if (count($approvedPendingTasks) > 0) {
                if (is_null($approvedPendingTasks[0]->state_pending_task_id)) {
                    Log::debug($approvedPendingTasks[0]->vehicle_id);
                    $approvedPendingTasks[0]->state_pending_task_id = StatePendingTask::PENDING;
                    $approvedPendingTasks[0]->save();
                }
            }
        }
        Log::debug('Begin end');
    }
}
