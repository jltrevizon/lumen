<?php

namespace App\Repositories;

use App\Models\PendingTaskCanceled;

class PendingTaskCanceledRepository {

    public function __construct()
    {

    }

    public function create($request){
        $pending_task_canceled = new PendingTaskCanceled();
        $pending_task_canceled->pending_task_id = $request->json()->get('pending_task_id');
        $pending_task_canceled->description = $request->json()->get('description');
        $pending_task_canceled->save();
    }
}
