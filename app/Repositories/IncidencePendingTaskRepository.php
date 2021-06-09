<?php

namespace App\Repositories;

use App\Models\Incidence;
use Illuminate\Support\Facades\DB;

class IncidencePendingTaskRepository {

    public function __construct()
    {

    }

    public function create($incidence_id, $pending_task_id){
        $incidence_pending_task = DB::table('incidence_pending_task')->insert([
            'incidence_id' => $incidence_id,
            'pending_task_id' => $pending_task_id
        ]);
        return $incidence_pending_task;
    }

}
