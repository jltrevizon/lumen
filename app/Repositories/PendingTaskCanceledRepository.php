<?php

namespace App\Repositories;

use App\Models\PendingTaskCanceled;
use Exception;

class PendingTaskCanceledRepository {

    public function __construct()
    {

    }

    public function create($request){
        try {
            $pending_task_canceled = PendingTaskCanceled::create($request->all());
            $pending_task_canceled->save();
            return $pending_task_canceled;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
