<?php

namespace App\Repositories;

use App\Models\Damage;
use App\Models\Order;
use App\Models\PendingTask;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Models\StatusDamage;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TradeState;
use App\Models\Vehicle;
use App\Repositories\GroupTaskRepository;
use App\Repositories\TaskReservationRepository;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PendingTaskCanceledRepository;
use App\Repositories\IncidencePendingTaskRepository;
use App\Repositories\PendingAuthorizationRepository as RepositoriesPendingAuthorizationRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

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
        IncidencePendingTaskRepository $incidencePendingTaskRepository,
        RepositoriesPendingAuthorizationRepository $pendingAuthorizationRepository,
        StateChangeRepository $stateChangeRepository,
        SquareRepository $squareRepository
        )
    {
        $this->groupTaskRepository = $groupTaskRepository;
        $this->taskReservationRepository = $taskReservationRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->incidenceRepository = $incidenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->receptionRepository = $receptionRepository;
        $this->pendingTaskCanceledRepository = $pendingTaskCanceledRepository;
        $this->incidencePendingTaskRepository = $incidencePendingTaskRepository;
        $this->pendingAuthorizationRepository = $pendingAuthorizationRepository;
        $this->stateChangeRepository = $stateChangeRepository;
        $this->squareRepository = $squareRepository;
    }

    public function getAll($request){
        return PendingTask::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->get();
    }

    public function pendingTasksFilter($request){
        return PendingTask::with($this->getWiths($request->with))
            ->filter($request->all())
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->paginate($request->input('per_page'));
    }

    public function getById($request, $id){
        $pending_task = PendingTask::with($this->getWiths($request->with))
                            ->findOrFail($id);
        return [ 'pending_task' => $pending_task ];
    }

    public function getPendingOrNextTask($request){
        $user = $this->userRepository->getById($request, Auth::id());
        if ($user->workshop_id != null) {
            return PendingTask::with($this->getWiths($request->with))
                ->filter($request->all())
                ->pendingOrInProgress()
                ->where('approved', true)
                ->get();
        }
        if($user['type_user_app_id'] == null && ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3)){
            return $this->getPendingOrNextTaskByRole($request);
        }
        return PendingTask::with($this->getWiths($request->with))
                ->byCampas($user->campas->pluck('id')->toArray())
                ->filter($request->all())
                ->pendingOrInProgress()
                ->canSeeHomework($user['type_user_app_id'])
                ->where('approved', true)
                ->get();
    }

    public function getPendingOrNextTaskByRole($request){
        $user = $this->userRepository->getById($request, Auth::id());
        return PendingTask::with($this->getWiths($request->with))
                ->byCampas($user->campas->pluck('id')->toArray())
                ->filter($request->all())
                ->pendingOrInProgress()
                ->where('approved', true)
                ->get();
    }

    public function create($request){
        return PendingTask::create($request->all());
    }

    public function finishAll($request) {
        $pending_task_ids = $request->input('pending_task_ids');
        PendingTask::whereIn($pending_task_ids)->updated([
            'state_pending_task_id' => StatePendingTask::FINISHED
        ]);
    }

    public function getVehicleById($vehicleId){
        return Vehicle::findOrFail($vehicleId);
    }

    public function update($request, $id){
        $pending_task = PendingTask::findOrFail($id);
        empty($request->state_pending_task_id) ? true : $this->isPause($request, $pending_task);
        $pending_task->update($request->all());
        if($request->input('approved') == 0 && $pending_task->damage_id != null){
           $this->closeDamage($pending_task->damage_id);
        }
        $this->realignPendingTask($pending_task);
        return ['pending_task' => $pending_task];
    }

    private function isPause($request, $pending_task){
        if($request->state_pending_task_id == StatePendingTask::PENDING){
            $pending_task->datetime_pause = new DateTime();
            $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);   
            $oldOrder = $pending_task->order;
            $nextPendingTask = PendingTask::where('group_task_id', $pending_task->group_task_id)
                ->where('approved', true)
                ->whereNull('state_pending_task_id')
                ->orderBy('order','ASC')
                ->first();
            $pending_task->order = $nextPendingTask->order ?? $pending_task->order;
            $pending_task->state_pending_task_id = null;
            $pending_task->save();
            if($nextPendingTask) {
                $nextPendingTask->order = $oldOrder;
                $nextPendingTask->state_pending_task_id = StatePendingTask::PENDING;
                $nextPendingTask->save();
            }
        }
    }

    private function diffDateTimes($datetime){
        $datetime1 = new DateTime($datetime);
        $diference = date_diff($datetime1, new DateTime());
        $minutes = $diference->days * 24 * 60;
        $minutes += $diference->h * 60;
        $minutes += $diference->i;
        return $minutes;
    }

    private function realignPendingTask($pendingTask){
        
        PendingTask::where('group_task_id', $pendingTask['group_task_id'])
                    ->where(function ($query){
                        return $query->whereNull('state_pending_task_id')
                                ->orWhere('state_pending_task_id', StatePendingTask::PENDING);
                    })
                    ->chunk(200, function ($pendingTasks) {
                        foreach ($pendingTasks as $pendingTask){
                            $pendingTask->update(['state_pending_task_id' => null]);
                        }
                    });
        $pendingInProgress = PendingTask::where('group_task_id', $pendingTask['group_task_id'])
                                    ->where('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                                    ->get();
        if(count($pendingInProgress) == 0) {
            $firstPendingTask = PendingTask::where('group_task_id', $pendingTask['group_task_id'])
                    ->where(function ($query){
                        return $query->whereNull('state_pending_task_id')
                                ->orWhere('state_pending_task_id', StatePendingTask::PENDING);
                    })
                    ->where('approved', true)
                    ->orderBy('order', 'ASC')
                    ->first();
            if (!is_null($firstPendingTask)) {
                $firstPendingTask->state_pending_task_id = StatePendingTask::PENDING;
                $firstPendingTask->datetime_pending = date('Y-m-d H:i:s');
                $firstPendingTask->save();
                $vehicle = $this->vehicleRepository->pendingOrInProgress($firstPendingTask->vehicle_id);
                $this->vehicleRepository->updateSubState($vehicle->id, null, count($vehicle?->lastGroupTask->pendingTasks) > 0 ? $vehicle?->lastGroupTask->pendingTasks[0] : null);
            } else {
                $pendingTaskOld = PendingTask::where('group_task_id', $pendingTask['group_task_id'])->first();
                $vehicle = $this->vehicleRepository->pendingOrInProgress($pendingTaskOld->vehicle_id);
                if($vehicle->sub_state_id != SubState::SOLICITUD_DEFLEET){
                    $this->vehicleRepository->updateSubState($vehicle->id, null, count($vehicle?->lastGroupTask->pendingTasks) > 0 ? $vehicle?->lastGroupTask->pendingTasks[0] : null);
                }
                $this->createPendingTaskCampa($vehicle, $pendingTask['group_task_id']);
            }
        }
    }

    private function createPendingTaskCampa($vehicle, $groupTaskId){
        PendingTask::create([
            'vehicle_id' => $vehicle->id,
            'reception_id' => $vehicle->lastReception->id ?? null,
            'task_id' => Task::TOCAMPA,
            'campa_id' => $vehicle->campa_id,
            'state_pending_task_id' => StatePendingTask::FINISHED,
            'user_start_id' => Auth::id(),
            'user_end_id' => Auth::id(),
            'group_task_id' => $groupTaskId,
            'order' => 100,
            'duration' => 0,
            'approved' => true,
            'datetime_pending' => date('Y-m-d H:i:s'),
            'datetime_start' => date('Y-m-d H:i:s'),
            'datetime_finish' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id){
        PendingTask::where('id', $id)
                ->delete();
        return [ 'message' => 'Pending task deleted' ];
    }

    public function orderPendingTask($request){
        foreach($request->input('pending_tasks') as $pending_task)
        {
            PendingTask::where('id', $pending_task['id'])->update($pending_task);
        }        
        $vehicle = $this->vehicleRepository->pendingOrInProgress($request->input('vehicle_id'));
        
        return $this->vehicleRepository->updateSubState($request->input('vehicle_id'), null, $vehicle?->lastGroupTask?->pendingTasks[0]);
    }

    public function startPendingTask($request){
        $pending_task = PendingTask::with($this->getWiths($request->with))
                        ->findOrFail($request->input('pending_task_id'));
        $vehicleWithOldPendingTask = $this->vehicleRepository->pendingOrInProgress($pending_task->vehicle_id);
        $vehicle = $this->getVehicleById($pending_task->vehicle_id);
        if($pending_task->state_pending_task_id == StatePendingTask::PENDING){
            $pending_task->state_pending_task_id = StatePendingTask::IN_PROGRESS;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->user_start_id = Auth::id();
            $pending_task->save();
            $detail_task = $this->taskRepository->getById([], $pending_task['task_id']);
            if($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET){
                $vehicle = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
                $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], $vehicle?->lastGroupTask?->pendingTasks[0]);
            }
            $this->squareRepository->freeSquare($vehicle->id);
            $this->updateStateOrder($request);
            return $this->getPendingOrNextTask($request);
        } else {
            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }
    }

    private function updateStateOrder($request){
        $pending_task = PendingTask::with(['task.subState.state', 'vehicle.orders'])
                        ->where('id', $request->input('pending_task_id'))
                        ->whereHas('vehicle.orders', function (Builder $builder) {
                            return $builder->where('state_id', '<>', State::FINISHED);
                        })
                    ->first();
        if($pending_task){
            $order = $pending_task['vehicle']['orders'][count($pending_task['vehicle']['orders']) - 1];
            $updateOrder = Order::findOrFail($order['id']);
            $updateOrder->state_id = $pending_task['task']['subState']['state']['id'];
            $updateOrder->save();
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
        $vehicle = $pending_task->vehicle;
        $vehicleWithOldPendingTask = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
        if($pending_task->state_pending_task_id == StatePendingTask::IN_PROGRESS){
            $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
            $pending_task->order = -1;
            $pending_task->user_end_id = Auth::id();
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);
            $pending_task->save();
            $pending_task->damage_id ? $this->closeDamage($pending_task->damage_id) : null;
            $pending_task_next = null;
            if (count($vehicle->lastGroupTask->approvedPendingTasks) > 0) 
            {
                $pending_task_next = $vehicle->lastGroupTask->approvedPendingTasks[0];         
            }
            if($pending_task_next){
                $pending_task_next->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task_next->datetime_pending= date('Y-m-d H:i:s');
                $pending_task_next->save();
                if($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET){
                    $vehicle = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
                    $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], count($vehicle?->lastGroupTask?->pendingTasks) > 0 ? $vehicle->lastGroupTask->pendingTasks[0] : null); // Si el vehículo ha sido reservado se actualiza para saber que está listo para entregar
                }
                return $this->getPendingOrNextTask($request);
            } else {
                if($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET){
                    $vehicle = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
                    $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], count($vehicle?->lastGroupTask?->pendingTasks) > 0 ? $vehicle->lastGroupTask->pendingTasks[0] : null); // Si el vehículo ha sido reservado se actualiza para saber que está listo para entregar
                }
                if($vehicle->trade_state_id == TradeState::PRE_RESERVED){
                    $this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], TradeState::RESERVED); // Si no hay más tareas el estado comercial pasa a reservado (sin tareas pendientes)
                    $vehicle->ready_to_delivery = true;
                    $vehicle->save();
                }
                PendingTask::create([
                    'vehicle_id' => $vehicle->id,
                    'reception_id' => $vehicle->lastReception->id ?? null,
                    'task_id' => Task::TOCAMPA,
                    'campa_id' => $vehicle->campa_id,
                    'state_pending_task_id' => StatePendingTask::FINISHED,
                    'user_start_id' => Auth::id(),
                    'user_end_id' => Auth::id(),
                    'group_task_id' => $pending_task->group_task_id,
                    'order' => -1,
                    'duration' => 0,
                    'approved' => true,
                    'datetime_pending' => date('Y-m-d H:i:s'),
                    'datetime_start' => date('Y-m-d H:i:s'),
                    'datetime_finish' => date('Y-m-d H:i:s')
                ]);
                return [
                    "status" => "OK",
                    "message" => "No hay más tareas"
                ];
            }
        } else {
            if($pending_task->task_id == Task::UBICATION){
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->order = -1;
                $pending_task->datetime_start = date('Y-m-d H:i:s');
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->user_end_id = Auth::id();
                $pending_task->save();
                if($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET){
                    $vehicle = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
                    $this->vehicleRepository->updateSubState($pending_task['vehicle_id'], $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], $vehicle?->lastGroupTask?->pendingTasks[0]); // Si el vehículo ha sido reservado se actualiza para saber que está listo para entregar
                }
                if($vehicle->trade_state_id == TradeState::PRE_RESERVED){
                    $this->vehicleRepository->updateTradeState($vehicle->id, TradeState::RESERVED); //Si el vehículo ha sido pre-reservado pasa a reservado (sin tareas pendientes)
                }
                return [ 'message' => 'Tareas terminadas' ];
            }
            return [ 'message' => 'La tarea no está en estado iniciada' ];
        }
    }

    private function closeDamage($damageId){
        $pendingTasks = PendingTask::where('damage_id', $damageId)
        ->where('approved', true)
        ->where(function($builder){
            return $builder->where('state_pending_task_id','<>',StatePendingTask::FINISHED)
                ->orWhereNull('state_pending_task_id');
        })
        ->get();
        if(count($pendingTasks) == 0){
            $damage = Damage::findOrFail($damageId);
            $damage->update(['status_damage_id' => StatusDamage::CLOSED, 'datetime_close' => Carbon::now()]);
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
        $vehicle = $this->vehicleRepository->getById($request, $request->input('vehicle_id'));
        $pendingTasks = PendingTask::where('group_task_id', $request->input('group_task_id'))
                        ->get();
        $task = $this->taskRepository->getById([], $request->input('task_id'));
        $pendingTask = new PendingTask();
        $pendingTask->task_id = $task['id'];
        $pendingTask->campa_id = $vehicle->campa_id;
        $pendingTask->vehicle_id = $request->input('vehicle_id');
        $pendingTask->group_task_id = $request->input('group_task_id');
        $pendingTask->duration = $task['duration'];
        $pendingTask->order = count($pendingTasks) - 1;
        $pendingTask->user_id = Auth::id();
        $pendingTask->save();

        return ['pending_task' => $pendingTask];
    }

    public function addPendingTaskFinished($request){
        $vehicle = Vehicle::with(['lastGroupTask.pendingTasks'])
                    ->findOrFail($request->input('vehicle_id'));
        $task = $this->taskRepository->getById([], $request->input('task_id'));
        $pendingTask = new PendingTask();
        $pendingTask->vehicle_id = $vehicle->id;
        $pendingTask->task_id = $task->id;
        $pendingTask->campa_id = $vehicle->campa_id;
        $pendingTask->state_pending_task_id = StatePendingTask::FINISHED;
        $pendingTask->group_task_id = $vehicle['lastGroupTask']['id'];
        $pendingTask->duration = $task['duration'];
        $pendingTask->order = -1;
        $pendingTask->approved = true;
        $pendingTask->status_color = 'green';
        $pendingTask->datetime_pending = date('Y-m-d');
        $pendingTask->datetime_start = date('Y-m-d');
        $pendingTask->datetime_finish = date('Y-m-d');
        $pendingTask->save();
        return $pendingTask;
    }

    public function updatePendingTaskFromValidation($groupTask, $taskIdActual, $taskIdNew){
        $pendingTask = PendingTask::where('group_task_id', $groupTask['id'])
            ->where('task_id', $taskIdActual)
            ->first();
        $pendingTask->task_id = $taskIdNew;
        $pendingTask->save();
    }

    public function updateApprovedPendingTaskFromValidation($request){
        $groupTask = $this->groupTaskRepository->groupTaskByQuestionnaireId($request->input('questionnaire_id'));
        $pendingTasksApproved = PendingTask::where('group_task_id', $groupTask['id'])
            ->where('approved', true)
            ->count();
        PendingTask::where('group_task_id', $groupTask['id'])
            ->where('task_id', $request->input('task_id'))
            ->chunk(200, function($pendingTasks) use($request, $pendingTasksApproved) {
                foreach($pendingTasks as $pendingTask) {
                    $pendingTask->update(['approved' => $request->input('approved'), 'order' => $pendingTasksApproved + 1]);
                }
            });
        $pendingTask = PendingTask::where('group_task_id', $groupTask['id'])
            ->where('task_id', $request->input('task_id'))
            ->first();
        return $this->realignPendingTask($pendingTask);
        return [
            'message' => 'Pending task update'
        ];
    }

    public function approvedFalse($vehicleId){
        PendingTask::where('vehicle_id', $vehicleId)
            ->where('approved', true)
            ->where(function ($query){
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                    ->orWhereNull('state_pending_task_id');
            })
            ->chunk(200, function($pendingTasks){
                foreach($pendingTasks as $pendingTask){
                    $pendingTask->update(['approved' => false]);
                }
            });
    }

    public function addPendingTaskFromIncidence($vehicleId, $taskId, $damage){
        $task = $this->taskRepository->getById([], $taskId);
        $vehicle = Vehicle::findOrFail($vehicleId);
        $groupTask = null;
        $orderLastPendingTask = 0;
        if($vehicle->lastGroupTask){
            $totalApproved = $vehicle->lastGroupTask->allApprovedPendingTasks;
            if(count($totalApproved) > 0){
                $orderLastPendingTask = $totalApproved[count($totalApproved) - 1]['order'];
            }
        }
        
        if($task->need_authorization == false){
            if($orderLastPendingTask > 0) {
                $groupTask = $vehicle->lastGroupTask;
            }
            else {
                $groupTask = $this->groupTaskRepository->createGroupTaskApprovedByVehicle($vehicleId);
            };
            PendingTask::create([
                'vehicle_id' => $vehicleId,
                'task_id' => $taskId,
                'campa_id' => $vehicle->campa_id,
                'group_task_id' => $groupTask->id,
                'state_pending_task_id' => $orderLastPendingTask > 0 ? null : StatePendingTask::PENDING,
                'damage_id' => $damage->id,
                'duration' => $task->duration,
                'order' => $orderLastPendingTask + 1,
                'approved' => true,
                'user_id' => Auth::id()
            ]);
        } else {
            $this->pendingAuthorizationRepository->create($vehicle->id, $task->id, $damage->id);
        }
    }

    public function createTransferTask($request){
        foreach($request->input('vehicle_ids') as $id) {
            $vehicle = Vehicle::findOrFail($id); 
            $task = $this->taskRepository->getById([], Task::TRANSFER);
            $groupTask = $this->groupTaskRepository->createGroupTaskApprovedByVehicle($vehicle->id);
            PendingTask::create([
                'vehicle_id' => $vehicle->id,
                'reception_id' => $vehicle->lastReception->id ?? null,
                'task_id' => $task->id,
                'campa_id' => $vehicle->campa_id,
                'state_pending_task_id' => StatePendingTask::IN_PROGRESS,
                'user_start' => Auth::id(),
                'group_task_id' => $groupTask->id,
                'duration' => $task->duration,
                'order' => 1,
                'approved' => true,
                'datetime_pending' => Carbon::now(),
                'datetime_start' => Carbon::now(),
                'user_id' => Auth::id()
            ]);
        }

        return response()->json([
            'message' => 'Task Transfer added!'
        ]);
    }

}
