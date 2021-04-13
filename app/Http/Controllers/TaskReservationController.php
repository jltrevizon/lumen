<?php

namespace App\Http\Controllers;

use App\Models\TaskReservation;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
class TaskReservationController extends Controller
{

    public function __construct(TaskController $taskController)
    {
        $this->taskController = $taskController;
    }

    public function create($request_id, $tasks, $vehicle_id){
        foreach($tasks as $task){
            $task_save = $this->taskController->getById($task['task_id']);
            $task_reservation = new TaskReservation();
            $task_reservation->request_id = $request_id;
            $task_reservation->vehicle_id = $vehicle_id;
            $task_reservation->task_id = $task_save['id'];
            $task_reservation->description = $task_save['name'];
            $task_reservation->save();
        }

    }
}
