<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\PendingTask;
use App\Repositories\AccessoryRepository;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\GroupTaskRepository;
use App\Repositories\ReceptionRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class PendingTaskAldController extends Controller
{

    public function __construct(
        TaskRepository $taskRepository,
        GroupTaskRepository $groupTaskRepository,
        VehicleRepository $vehicleRepository,
        UserRepository $userRepository,
        ReceptionRepository $receptionRepository,
        AccessoryRepository $accessoryRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
        $this->receptionRepository = $receptionRepository;
        $this->accessoryRepository = $accessoryRepository;
    }

    public function createFromArray(Request $request){
        try {
            $groupTask = $this->groupTaskRepository->create($request);
            foreach($request->input('tasks') as $task){
                $pending_task = new PendingTask();
                $pending_task->vehicle_id = $request->input('vehicle_id');
                $taskDescription = $this->taskRepository->getById($task['task_id']);
                $pending_task->task_id = $task['task_id'];
                if($task['task_order'] == 1){
                    $pending_task->state_pending_task_id = 1;
                    $pending_task->datetime_pending = date('Y-m-d H:i:s');
                    $this->vehicleRepository->updateState($pending_task['vehicle_id'], 1);
                    //El estado comercial del vehículo pasa a No disponible
                    //$this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], 5);
                }
                $pending_task->group_task_id = $groupTask->id;
                $pending_task->duration = $taskDescription['duration'];
                $pending_task->order = $task['task_order'];
                $pending_task->save();
            }
            $this->createTaskWashed($request->input('vehicle_id'), $groupTask);
            $this->createTaskUbication($request->input('vehicle_id'), $groupTask);
            //return $groupTask;
            $this->vehicleRepository->updateBack($request);

            $user = $this->userRepository->getById(Auth::id());
           //return $user;
            $this->vehicleRepository->updateCampa($request->input('vehicle_id'), $user['campas'][0]['id']);
            $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));
            if($request->input('has_accessories')){
                $this->receptionRepository->update($reception['id']);
                $this->accessoryRepository->create($reception['id'], $request->input('accessories'));
            }
            return [
                'message' => 'OK'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createTaskWashed($vehicle_id, $group_task){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $vehicle_id;
        $taskDescription = $this->taskRepository->getById(28);
        $pending_task->group_task_id = $group_task->id;
        $pending_task->task_id = $taskDescription['id'];
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 99;
        $pending_task->save();
    }

    public function createTaskUbication($vehicle_id, $group_task){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $vehicle_id;
        $taskDescription = $this->taskRepository->getById(1);
        $pending_task->group_task_id = $group_task->id;
        $pending_task->task_id = $taskDescription['id'];
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 100;
        $pending_task->save();
    }
}
