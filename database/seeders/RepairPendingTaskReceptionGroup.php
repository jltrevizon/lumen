<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairPendingTaskReceptionGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql1 = <<<SQL
            Select COUNT(pt1.vehicle_id) from pending_tasks pt1 where pt1.reception_id is null and pt1.vehicle_id = vehicles.id
        SQL;
        $sql2 = <<<SQL
            Select COUNT(pt1.vehicle_id) from pending_tasks pt1 where pt1.vehicle_id = vehicles.id and pt1.reception_id is not null
        SQL;
        $sql3 = <<<SQL
            Select COUNT(pt1.vehicle_id) from pending_tasks pt1 where pt1.vehicle_id = vehicles.id and pt1.reception_id is null and pt1.group_task_id is not null
        SQL;
        Log::debug('RepairPendingTaskReceptionGroup ' . PendingTask::whereNull('reception_id')->count());
        $vehicles = Vehicle::where('campa_id', 3)
            ->selectRaw('id, plate')
            ->selectRaw(DB::raw('(' . $sql1 . ') as reception_null'))
            ->selectRaw(DB::raw('(' . $sql2 . ') as reception_not_null'))
            ->selectRaw(DB::raw('(' . $sql3 . ') as reception_not_null_group_null'))
            ->whereRaw(DB::raw('(' . $sql3 . ') > 0'))
            ->whereRaw(DB::raw('(' . $sql2 . ') = 0'))
            ->get();
        foreach ($vehicles as $key => $vehicle) {
            # code...
            if (count($vehicle->pendingTasks) === 1) {
                $pendingTask = $vehicle->pendingTasks[0];
                if ($pendingTask->task_id === 38) {
                    $reception = $vehicle->lastReception;
                    if (is_null($reception->group_task_id)) {
                        $reception->group_task_id = $pendingTask->group_task_id;
                        $reception->save();
                    }
                    $pendingTask->reception_id = $vehicle->lastReception->id;
                    $pendingTask->save();
                } else {
                    Log::debug($pendingTask->group_task_id);
                }
            }
        }
    }
}
