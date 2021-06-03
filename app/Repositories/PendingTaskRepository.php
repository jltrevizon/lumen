<?php

namespace App\Repositories;
use App\Models\PendingTask;
use App\Models\VehiclePicture;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskReservationRepository;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PendingTaskCanceledRepository;
use App\Repositories\AccessoryRepository;

class PendingTaskRepository {

    public function __construct(
        GroupTaskRepository $groupTaskRepository,
        TaskReservationRepository $taskReservationRepository,
        TaskRepository $taskRepository,
        UserRepository $userRepository,
        IncidenceRepository $incidenceRepository,
        VehicleRepository $vehicleRepository,
        ReceptionRepository $receptionRepository,
        PendingTaskCanceledRepository $pendingTaskCanceledRepository,
        AccessoryRepository $accessoryRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
        $this->taskReservationRepository = $taskReservationRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->incidenceRepository = $incidenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->receptionRepository = $receptionRepository;
        $this->pendingTaskCanceledRepository = $pendingTaskCanceledRepository;
        $this->accessoryRepository = $accessoryRepository;
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
        if($user->role_id == 4){
            return PendingTask::with(['task','state_pending_task','group_task','vehicle','incidence'])
                            ->whereHas('vehicle', function(Builder $builder) use($user){
                                return $builder->where('campa_id', $user->campa_id);
                            })
                            ->where('state_pending_task_id', 1)
                            ->orWhere('state_pending_task_id', 2)
                            ->get();
        }
        if($user->role_id == 5){
            return PendingTask::with(['task','state_pending_task','group_task','vehicle','incidence'])
                        ->whereHas('vehicle', function(Builder $builder) use($user){
                            return $builder->where('campa_id', $user->campa_id);
                        })
                        ->where(function ($query) {
                            return $query->where('state_pending_task_id', 1)
                                    ->orWhere('state_pending_task_id', 2);
                        })
                        ->where('task_id', 1)
                        ->get();
        }
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
        if($request->json()->get('vehicle_id')) $pending_task->vehicle_id = $request->json()->get('vehicle_id');
        if($request->json()->get('task_id')) $pending_task->task_id = $request->json()->get('task_id');
        if($request->json()->get('state_pending_task_id')) $pending_task->state_pending_task_id = $request->json()->get('state_pending_task_id');
        if($request->json()->get('group_task_id')) $pending_task->group_task_id = $request->json()->get('group_task_id');
        if($request->json()->get('incidence_id')) $pending_task->incidence_id = $request->json()->get('incidence_id');
        if($request->json()->get('duration')) $pending_task->duration = $request->json()->get('duration');
        if($request->json()->get('order')) $pending_task->order = $request->json()->get('order');
        if($request->json()->get('code_authorization')) $pending_task->code_authorization = $request->json()->get('code_authorization');
        if($request->json()->get('trade_state_id')) $pending_task->trade_state_id = $request->json()->get('trade_state_id');

        $pending_task->updated_at = date('Y-m-d H:i:s');
        $pending_task->save();
        return $pending_task;
    }

    public function createIncidence($request){
        $incidence = $this->incidenceRepository->createIncidence($request);
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        $pending_task->incidence_id = $incidence->id;
        $pending_task->status_color = "Red";
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
                //El estado comercial del vehículo pasa a No disponible
                //$this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], 5);
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
        $reception = $this->receptionRepository->create($request->json()->get('vehicle_id'), $request->json()->get('has_accessories'));
        if($request->json()->get('has_accessories')){
            $this->accessoryRepository->create($reception->id, $request->json()->get('accessories'));
        }
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

    public function orderPendingTask($request){
        foreach($request->json()->get('pending_tasks') as $pending_task){
            $update_pending_task = PendingTask::where('id', $pending_task['id'])
                                            ->first();
            if($update_pending_task->state_pending_task_id != 2 && $update_pending_task->state_pending_task_id != 3 ){
                $update_pending_task->state_pending_task_id = null;
                $update_pending_task->datetime_pending = null;
                $update_pending_task->order = $pending_task['order'];
                $update_pending_task->save();
            }
        }
        $pending_task = PendingTask::where('vehicle_id', $request->json()->get('vehicle_id'))
                                ->where(function ($query) {
                                    return $query->where('state_pending_task_id', null)
                                            ->orWhere('state_pending_task_id', 1);
                                })
                                ->orderBy('order','asc')
                                ->first();
        $pending_task->state_pending_task_id = 1;
        $pending_task->datetime_pending = date("Y-m-d H:i:s");
        $pending_task->save();
        return $pending_task;
    }

    public function startPendingTask($request){
        $pending_task = PendingTask::with(['incidence'])
                                ->where('id', $request->json()->get('pending_task_id'))
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

    public function cancelPendingTask($request){
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        $pending_task->state_pending_task_id = 1;
        $pending_task->datetime_start = null;
        $pending_task->save();
        $this->pendingTaskCanceledRepository->create($request);
        return $this->getPendingOrNextTask();
    }

    public function finishPendingTask($request){
        $pending_task = PendingTask::where('id', $request->json()->get('pending_task_id'))
                                ->first();
        $vehicle = $this->vehicleRepository->getById($pending_task['vehicle_id']);
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
                //Si el vehículo ha sido reservado se actualiza para saber que está listo para entregar
                if($vehicle->trade_state_id == 2){
                    //Si no hay más tareas el estado comercial pasa a reservado (sin tareas pendientes)
                    $this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], 1);
                    $vehicle->ready_to_delivery = true;
                    $vehicle->save();
                }
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
                //Cuando el vehículo se ubica cambia el estado a disponible
                $this->vehicleRepository->updateState($pending_task['vehicle_id'], 1);
                if($vehicle->trade_state_id == 2){
                    //Si el vehículo ha sido pre-reservado pasa a reservado (sin tareas pendientes)
                    $this->vehicleRepository->updateTradeState($vehicle->id, 1);
                }
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
        return PendingTask::with(['vehicle.campa','vehicle.state','vehicle.category','task'])
                ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                        return $builder->where('company_id', $request->json()->get('company_id'));
                    })
                ->where('state_pending_task_id', $request->json()->get('state_pending_task_id'))
                ->get();
    }

    public function getPendingTaskByStateCampa($request){
        return PendingTask::with(['vehicle.campa','vehicle.state','vehicle.category','task'])
                ->whereHas('vehicle.campa', function (Builder $builder) use($request){
                        return $builder->where('id', $request->json()->get('campa_id'));
                    })
                ->where('state_pending_task_id', $request->json()->get('state_pending_task_id'))
                ->get();
    }

    public function getPendingTaskByPlate($request){
        $pending_task = PendingTask::with(['vehicle','state_pending_task'])
                        ->whereHas('vehicle', function (Builder $builder) use($request) {
                            return $builder->where('plate', $request->json()->get('plate'));
                        })
                        ->where(function ($query) {
                            return $query->where('state_pending_task_id', 1)
                                    ->orWhere('state_pending_task_id', 2);
                        })
                        ->first();
        return $pending_task;
    }

    public function getPendingTasksByPlate($request){
        $vehicle = $this->vehicleRepository->getByPlate($request);
        $group = $this->groupTaskRepository->getLastByVehicle($vehicle->id);
        return PendingTask::with(['vehicle','state_pending_task','task'])
        ->where('group_task_id', $group->id)
        ->get();
    }
}
