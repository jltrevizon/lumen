<?php

namespace App\Repositories;
use App\Models\PendingTask;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TradeState;
use App\Models\VehiclePicture;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskReservationRepository;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PendingTaskCanceledRepository;
use App\Repositories\AccessoryRepository;
use App\Repositories\IncidencePendingTaskRepository;
use Exception;

class PendingTaskRepository extends Repository {

    public function __construct(
        GroupTaskRepository $groupTaskRepository,
        TaskReservationRepository $taskReservationRepository,
        TaskRepository $taskRepository,
        UserRepository $userRepository,
        IncidenceRepository $incidenceRepository,
        VehicleRepository $vehicleRepository,
        ReceptionRepository $receptionRepository,
        PendingTaskCanceledRepository $pendingTaskCanceledRepository,
        AccessoryRepository $accessoryRepository,
        IncidencePendingTaskRepository $incidencePendingTaskRepository)
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
        $this->incidencePendingTaskRepository = $incidencePendingTaskRepository;
    }

    public function getAll($request){
        return PendingTask::with($this->getWiths($request->with))
                    ->get();
    }

    public function createPendingTaskFromReservation($vehicle_id, $request_id){
        $groupTask = $this->groupTaskRepository->createWithVehicleId($vehicle_id);
        $has_pending_task = PendingTask::where('vehicle_id', $vehicle_id)
                                    ->where('state_pending_task_id', '<', StatePendingTask::FINISHED)
                                    ->get();
        if(count($has_pending_task) > 0) return [ 'message' => 'El vehículo tiene tareas pendientes o en curso' ];
        $tasks = $this->taskReservationRepository->getByRequest($request_id);
        $this->createTasks($tasks, $groupTask->id);
        $this->createUbication($vehicle_id, $groupTask->id);
        return [ 'message' => 'OK' ];
    }

    private function createTasks($tasks, $groupTaskId){
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $task['vehicle_id'];
            $taskDescription = $this->taskRepository->getById($task['task_id']);
            $pending_task->task_id = $task['task_id'];
            if($task['order'] == 1){
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->order = $task['order'];
            $pending_task->save();
        }
    }

    private function createUbication($vehicleId, $groupTaskId){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $vehicleId;
        $taskDescription = $this->taskRepository->getById(Task::UBICATION);
        $pending_task->group_task_id = $groupTaskId;
        $pending_task->task_id = $taskDescription->id;
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 100;
        $pending_task->save();
    }

    public function getById($request, $id){
        $pending_task = PendingTask::with($this->getWiths($request->with))
                            ->findOrFail($id);
        return [ 'pending_task' => $pending_task ];
    }

    public function getPendingOrNextTask($request){
        $user = $this->userRepository->getById($request, Auth::id());
        if($user['type_user_app_id'] == null && ($user['role_id'] == 1 || $user['role_id'] == 2)){
            return $this->getPendingOrNextTaskByRole($request);
        }
        return PendingTask::with($this->getWiths($request->with))
                ->byCampas($user->campas->pluck('id')->toArray())
                ->pendingOrInProgress()
                //->canSeeHomework($user['type_user_app_id'])
                ->where('approved', true)
                ->get();
    }

    public function getPendingOrNextTaskByRole($request){
        $user = $this->userRepository->getById($request, Auth::id());
        return PendingTask::with($this->getWiths($request->with))
                ->byCampas($user->campas->pluck('id')->toArray())
                ->pendingOrInProgress()
                ->where('approved', true)
                ->get();
    }

    public function create($request){
        return PendingTask::create($request->all());
    }

    public function update($request, $id){
        $pending_task = PendingTask::findOrFail($id);
        $pending_task->update($request->all());
        return ['pending_task' => $pending_task];
    }

    public function createIncidence($request){
        $incidence = $this->incidenceRepository->createIncidence($request);
        $pending_task = PendingTask::findOrFail('id', $request->input('pending_task_id'));
        $pending_task->status_color = "Red";
        $pending_task->save();
        $this->incidencePendingTaskRepository->create($incidence->id, $pending_task->id);
        return [ 'message' => 'Ok' ];
    }

    public function resolvedIncidence($request){
        $this->incidenceRepository->resolved($request);
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $pending_task->status_color = 'Green';
        $pending_task->save();
        return PendingTask::with($this->getWiths($request->with))
                ->findOrFail($request->input('pending_task_id'));
    }

    public function delete($id){
        PendingTask::where('id', $id)
                ->delete();
        return [ 'message' => 'Pending task deleted' ];
    }

    public function orderPendingTask($request){
        foreach($request->input('pending_tasks') as $pending_task){
            $update_pending_task = PendingTask::where('id', $pending_task['id'])
                                            ->first();
            if($update_pending_task->state_pending_task_id != StatePendingTask::IN_PROGRESS && $update_pending_task->state_pending_task_id != StatePendingTask::FINISHED){
                $update_pending_task->state_pending_task_id = null;
                $update_pending_task->datetime_pending = null;
                $update_pending_task->order = $pending_task['order'];
                $update_pending_task->save();
            }
        }
        $pending_task = PendingTask::where('vehicle_id', $request->input('vehicle_id'))
                            ->where(function ($query) {
                                return $query->where('state_pending_task_id', null)
                                        ->orWhere('state_pending_task_id', StatePendingTask::PENDING);
                            })
                            ->orderBy('order','asc')
                            ->first();
        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
        $pending_task->datetime_pending = date("Y-m-d H:i:s");
        $pending_task->save();
        return $pending_task;
    }

    public function startPendingTask($request){
        $pending_task = PendingTask::with($this->getWiths($request->with))
                                ->findOrFail($request->input('pending_task_id'));

        if($pending_task->state_pending_task_id == StatePendingTask::PENDING){
            $pending_task->state_pending_task_id = StatePendingTask::IN_PROGRESS;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->save();
            $detail_task = $this->taskRepository->getById($pending_task['task_id']);
            $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], $detail_task['sub_state_id']);
            return $this->getPendingOrNextTask($request);
        } else {
            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }
    }

    public function cancelPendingTask($request){
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
        $pending_task->datetime_start = null;
        $pending_task->save();
        $this->pendingTaskCanceledRepository->create($request);
        return $this->getPendingOrNextTask($request);
    }

    public function finishPendingTask($request){
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $vehicle = $this->vehicleRepository->getById($pending_task['vehicle_id']);
        if($pending_task->state_pending_task_id == StatePendingTask::IN_PROGRESS){
            $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->save();
            $pending_task_next = PendingTask::where('group_task_id', $pending_task->group_task_id)
                                    ->where('order','>',$pending_task->order)
                                    ->where('approved', true)
                                    ->orderBy('order', 'asc')
                                    ->first();
            if($pending_task_next){
                $pending_task_next->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task_next->datetime_pending= date('Y-m-d H:i:s');
                $pending_task_next->save();
                return $this->getPendingOrNextTask($request);
            } else {
                $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], SubState::CAMPA); // Si el vehículo ha sido reservado se actualiza para saber que está listo para entregar
                if($vehicle->trade_state_id == TradeState::PRE_RESERVED){
                    $this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], TradeState::RESERVED); // Si no hay más tareas el estado comercial pasa a reservado (sin tareas pendientes)
                    $vehicle->ready_to_delivery = true;
                    $vehicle->save();
                }
                return [
                    "status" => "OK",
                    "message" => "No hay más tareas"
                ];
            }
        } else {
            if($pending_task->task_id == Task::UBICATION){
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->datetime_start = date('Y-m-d H:i:s');
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->save();
                $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], SubState::CAMPA); //Cuando el vehículo se ubica cambia el estado a disponible
                if($vehicle->trade_state_id == TradeState::PRE_RESERVED){
                    $this->vehicleRepository->updateTradeState($vehicle->id, TradeState::RESERVED); //Si el vehículo ha sido pre-reservado pasa a reservado (sin tareas pendientes)
                }
                return [ 'message' => 'Tareas terminadas' ];
            }
            return [ 'message' => 'La tarea no está en estado iniciada' ];
        }
    }

    public function getPendingTaskByStateCampa($request){
        return PendingTask::with($this->getWiths($request->with))
                ->byCampas($request->input('campas'))
                ->where('state_pending_task_id', $request->input('state_pending_task_id'))
                ->get();
    }

    public function getPendingTaskByPlate($request){
        return PendingTask::with($this->getWiths($request->with))
                ->byPlate($request->input('plate'))
                ->pendingOrInProgress()
                ->first();
    }

    public function getPendingTasksByPlate($request){
        $vehicle = $this->vehicleRepository->getByPlate($request);
        $group = $this->groupTaskRepository->getLastByVehicle($vehicle->id);
        return PendingTask::with($this->getWiths($request->with))
                ->where('group_task_id', $group->id)
                ->where('approved', true)
                ->get();
    }

    public function addPendingTask($request){
        $pendingTasks = PendingTask::where('group_task_id', $request->input('group_task_id'))
                        ->get();
        $task = $this->taskRepository->getById($request->input('task_id'));
        $pendingTask = new PendingTask();
        $pendingTask->task_id = $task['id'];
        $pendingTask->vehicle_id = $request->input('vehicle_id');
        $pendingTask->group_task_id = $request->input('group_task_id');
        $pendingTask->duration = $task['duration'];
        $pendingTask->order = count($pendingTasks) - 1;
        $pendingTask->save();

        return ['pending_task' => $pendingTask];
    }

}
