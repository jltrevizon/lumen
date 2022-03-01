<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class IncidenceTaskRepository extends Repository {

    public function create($incidenceId, $taskId){
        $incidenceTask = DB::table('incicence_task')->insert([
            'incidence_id' => $incidenceId,
            'task_id' => $taskId
        ]);

        return $incidenceTask;
    }

}