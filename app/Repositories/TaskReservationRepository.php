<?php

namespace App\Repositories;
use App\Repositories\TaskRepository;
use App\Models\TaskReservation;

class TaskReservationRepository {

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create($request_id, $tasks, $vehicle_id){
        foreach($tasks as $task){
            $task_save = $this->taskRepository->getById($task['task_id']);
            $task_reservation = new TaskReservation();
            $task_reservation->request_id = $request_id;
            $task_reservation->vehicle_id = $vehicle_id;
            $task_reservation->order = $task['order'];
            $task_reservation->task_id = $task_save['id'];
            $task_reservation->description = $task_save['name'];
            $task_reservation->save();
        }
    }

    public function getByRequest($request_id){
        return TaskReservation::where('request_id', $request_id)
                            ->get();
    }

}
