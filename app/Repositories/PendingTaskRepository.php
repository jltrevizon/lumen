<?php

namespace App\Repositories;
use App\Models\PendingTask;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskReservationRepository;
use App\Repositories\TaskRepository;

class PendingTaskRepository {

    public function __construct(GroupTaskRepository $groupTaskRepository, TaskReservationRepository $taskReservationRepository, TaskRepository $taskRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
        $this->taskReservationRepository = $taskReservationRepository;
        $this->taskRepository = $taskRepository;
    }

    public function createPendingTaskFromReservation($vehicle_id, $request_id){
        $groupTask = $this->groupTaskRepository->createWithVehicleId($vehicle_id);
        $has_pending_task = PendingTask::where('vehicle_id', $vehicle_id)
                                    ->where('state_pending_task_id', '<', 3)
                                    ->get();
        if(count($has_pending_task) > 0){
            return [
                'message' => 'El vehículo tiene tareas pendientes o en curso'
            ];
        }
        $tasks = $this->taskReservationRepository->getByRequest($request_id);

        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $task['vehicle_id'];
            $taskDescription = $this->taskRepository->getById($task['task_id']);
            $pending_task->task_id = $task['task_id'];
            if($task['order'] == 1){
                $pending_task->state_pending_task_id = 1;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $groupTask->id;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['order'];
            $pending_task->save();
        }
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $vehicle_id;
        $taskDescription = $this->taskRepository->getById(1);
        $pending_task->group_task_id = $groupTask->id;
        $pending_task->task_id = $taskDescription->id;
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 100;
        $pending_task->save();
        return [
            'message' => 'OK'
        ];
    }

}
