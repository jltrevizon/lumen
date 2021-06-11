<?php

namespace App\Repositories;

use App\Models\Incidence;
use Exception;
use Illuminate\Support\Facades\DB;

class IncidencePendingTaskRepository {

    public function __construct()
    {

    }

    public function create($incidence_id, $pending_task_id){
        try {
            $incidence_pending_task = DB::table('incidence_pending_task')->insert([
                'incidence_id' => $incidence_id,
                'pending_task_id' => $pending_task_id
            ]);
            return $incidence_pending_task;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
