<?php

namespace App\Repositories;
use App\Models\Task;

class TaskRepository {

    public function getById($id){
        return Task::where('id', $id)
                    ->first();
    }

}
