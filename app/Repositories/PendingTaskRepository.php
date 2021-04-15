<?php

namespace App\Repositories;
use App\Models\PendingTask;
use App\Models\VehiclePicture;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskReservationRepository;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PendingTaskRepository {

    public function __construct(
        GroupTaskRepository $groupTaskRepository,
        TaskReservationRepository $taskReservationRepository,
        TaskRepository $taskRepository,
        UserRepository $userRepository,
        IncidenceRepository $incidenceRepository,
        VehicleRepository $vehicleRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
        $this->taskReservationRepository = $taskReservationRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->incidenceRepository = $incidenceRepository;
        $this->vehicleRepository = $vehicleRepository;
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

    public function getById($id){
        $task = PendingTask::where('id', $id)
                                ->first();
        $vehicle_pictures = VehiclePicture::where('vehicle_id', $task->vehicle_id)
                                    ->first();
        $pending_task = PendingTask::with(['vehicle','task','state_pending_task','incidence'])
                                    ->where('id', $id)
                                    ->first();
        return [
            'task' => $pending_task,
            'picture' => $vehicle_pictures
        ];
    }

    public function getPendingOrNextTask(){
        $user = $this->userRepository->getById(Auth::id());
        return PendingTask::with(['task','state_pending_task','group_task','vehicle'])
                        ->whereHas('vehicle', function(Builder $builder) use($user){
                            return $builder->where('campa_id', $user->campa_id);
                        })
                        ->where('state_pending_task_id', 1)
                        ->orWhere('state_pending_task_id', 2)
                        ->get();
    }

    public function create($request){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $request->get('vehicle_id');
        $pending_task->task_id = $request->get('task_id');
        if(isset($request['state_pending_task_id'])) $pending_task->state_pending_task_id = $request->get('state_pending_task_id');
        if(isset($request['incidence_id'])) $pending_task->incidence_id = $request->get('incidence_id');
        $pending_task->group_task_id = $request->get('group_task_id');
        $pending_task->duration = $request->get('duration');
        $pending_task->order = $request->get('order');
        $pending_task->save();
        return $pending_task;
    }

    public function update($request, $id){
        $pending_task = PendingTask::where('id', $id)
                            ->first();
        if(isset($request['vehicle_id'])) $pending_task->vehicle_id = $request->get('vehicle_id');
        if(isset($request['task_id'])) $pending_task->task_id = $request->get('task_id');
        if(isset($request['state_pending_task_id'])) $pending_task->state_pending_task_id = $request->get('state_pending_task_id');
        if(isset($request['group_task_id'])) $pending_task->group_task_id = $request->get('group_task_id');
        if(isset($request['incidence_id'])) $pending_task->incidence_id = $request->get('incidence_id');
        if(isset($request['duration'])) $pending_task->duration = $request->get('duration');
        if(isset($request['order'])) $pending_task->order = $request->get('order');
        $pending_task->updated_at = date('Y-m-d H:i:s');
        $pending_task->save();
        return $pending_task;
    }

    public function createIncidence($request){
        $incidence = $this->incidenceRepository->createIncidence($request);
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        $pending_task->incidence_id = $incidence->id;
        $pending_task->save();
        return [
            'message' => 'Ok'
        ];
    }

    public function resolvedIncidence($request){
        $this->incidenceRepository->resolved($request);
        return PendingTask::with(['incidence'])
                        ->where('id', $request->json()->get('pending_task_id'))
                        ->first();
    }

    public function createFromArray($request){
        $groupTask = $this->groupTaskRepository->create($request);
        foreach($request->json()->get('tasks') as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $request->json()->get('vehicle_id');
            $taskDescription = $this->taskRepository->getById($task['task_id']);
            $pending_task->task_id = $task['task_id'];
            if($task['task_order'] == 1){
                $pending_task->state_pending_task_id = 1;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
                $this->vehicleRepository->updateState($pending_task['vehicle_id'], 1);
            }
            $pending_task->group_task_id = $groupTask->id;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['task_order'];
            $pending_task->save();
        }
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $request->json()->get('vehicle_id');
        $taskDescription = $this->taskRepository->getById(1);
        $pending_task->group_task_id = $groupTask->id;
        $pending_task->task_id = $taskDescription->id;
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 100;
        $pending_task->save();
        $this->vehicleRepository->updateGeolocation($request);
        return [
            'message' => 'OK'
        ];
    }

    public function delete($id){
        PendingTask::where('id', $id)
                ->delete();
        return [
            'message' => 'Pending task deleted'
        ];
    }

    public function startPendingTask($request){
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        if($pending_task->state_pending_task_id == 1){
            $pending_task->state_pending_task_id = 2;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->save();
            $detail_task = $this->taskRepository->getById($pending_task['task_id']);
            $this->vehicleRepository->updateState($pending_task['vehicle_id'], $detail_task['sub_state']['state']['id']);
            return $this->getPendingOrNextTask();
        } else {
            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }
    }

    public function finishPendingTask($request){
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        if($pending_task->state_pending_task_id == 2){
            $pending_task->state_pending_task_id = 3;
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->save();
            $pending_task_next = PendingTask::where('group_task_id', $pending_task->group_task_id)
                                    ->where('order','>',$pending_task->order)
                                    ->orderBy('order', 'asc')
                                    ->first();
            if($pending_task_next){
                $pending_task_next->state_pending_task_id = 1;
                $pending_task_next->datetime_pending= date('Y-m-d H:i:s');
                $pending_task_next->save();
                $this->vehicleRepository->updateState($pending_task['vehicle_id'], 1);
                return $this->getPendingOrNextTask();
            } else {
                return [
                    "status" => "OK",
                    "message" => "No hay más tareas"
                ];
            }
        } else {
            if($pending_task->task_id == 1){
                $pending_task->state_pending_task_id = 3;
                $pending_task->datetime_start = date('Y-m-d H:i:s');
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->save();
                $this->vehicleRepository->updateState($pending_task['vehicle_id'], 5);
                return [
                    'message' => 'Tareas terminadas'
                ];
            }
            return [
                'message' => 'La tarea no está en estado iniciada'
            ];
        }

    }

    public function getPendingTaskByState($request){
        return PendingTask::with(['vehicle','task'])
                ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                ->where('state_pending_task_id', $request->json()->get('state_pending_task_id'))
                ->get();
    }

    public function getPendingTaskByStateCampa($request){
        return PendingTask::with(['vehicle','task'])
                ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                        return $builder->where('id', $request->json()->get('campa_id'));
                    })
                ->where('state_pending_task_id', $request->json()->get('state_pending_task_id'))
                ->get();
    }
}
