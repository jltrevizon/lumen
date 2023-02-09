<?php

namespace Database\Seeders;

use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairPendintaskReceptionNull extends Seeder
{

    public function __construct()
    { }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '-1');
        $sql = <<<SQL
        Select pt.*
        from pending_tasks pt, vehicles v2 
        where pt.reception_id is null and v2.id = pt.vehicle_id and v2.sub_state_id = 10
        and (
            Select COUNT(r.id) 
            from receptions r 
            where r.vehicle_id = pt.vehicle_id
        ) = 0
        SQL;
        $variable = DB::select($sql);
        foreach ($variable as $key => $value) {
            $pendingTask = PendingTask::where('id', $value->id)
                ->whereRaw('EXISTS(Select id from vehicles where id = pending_tasks.vehicle_id and deleted_at is null)')
                ->first();
            if (is_null($pendingTask->vehicle->lastReception)) {
                Log::debug($value->id);
                $vehicle = $pendingTask->vehicle;
                $reception = new Reception();
                $reception->campa_id = $pendingTask->campa_id ?? 3;
                $reception->vehicle_id = $vehicle->id;
                $reception->finished = false;
                $reception->has_accessories = false;
                $reception->type_model_order_id = $vehicle->type_model_order_id;

                $group_task = new GroupTask();
                $group_task->vehicle_id =  $vehicle->id;
                $group_task->questionnaire_id = null;
                $group_task->approved_available = 1;
                $group_task->approved = 1;
                $group_task->save();

                $reception->group_task_id = $group_task->id;
                $reception->save();

                $pendingTask->reception_id = $reception->id;
                $pendingTask->save();
            }
        }
    }
}
