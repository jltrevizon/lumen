<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendingTask;
use App\Models\StatePendingTask;

class RepairStatusPendingTaskFinishedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PendingTask::where('state_pending_task_id', StatePendingTask::FINISHED)->update([
            'order'=> -1
        ]);
    }
}
