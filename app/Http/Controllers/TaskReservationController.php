<?php

namespace App\Http\Controllers;

use App\Models\TaskReservation;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Repositories\TaskReservationRepository;

class TaskReservationController extends Controller
{

    public function __construct(TaskController $taskController, TaskReservationRepository $taskReservationRepository)
    {
        $this->taskController = $taskController;
        $this->taskReservationRepository = $taskReservationRepository;
    }

    public function create($request_id, $tasks, $vehicle_id){
        return $this->taskReservationRepository->create($request_id, $tasks, $vehicle_id);
    }
}
