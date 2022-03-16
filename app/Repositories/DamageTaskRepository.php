<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class DamageTaskRepository extends Repository {

    public function create($damageId, $taskId){
        DB::table('damage_task')->insert([
            'damage_id' => $damageId,
            'task_id' => $taskId
        ]);
    }

}