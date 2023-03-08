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
use Illuminate\Support\Facades\Log;

class PendingTaskRepository extends Repository
{

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
        SquareRepository $squareRepository,
        HistoryLocationRepository $historyLocationRepository
    ) {
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
        $this->historyLocationRepository = $historyLocationRepository;
    }

    public function getAll($request)
    {
        return PendingTask::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function pendingTasksFilter($request)
    {
        ini_set("memory_limit", "-1");
        set_time_limit(60);
        return PendingTask::with($this->getWiths($request->with))
            ->filter($request->all())
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->paginate($request->input('per_page'));
    }

    public function pendingTasksFilterDownloadFile($request)
    {
        return PendingTask::select([
            'id',
            'vehicle_id',
            'task_id',
            'user_start_id',
            'user_end_id',
            'state_pending_task_id',
            'datetime_start',
            'datetime_finish',
            'total_paused',
            'group_task_id',
            'reception_id'
        ])
            ->with(array(
                'task'  => function ($query) {
                    $query->select('id', 'name');
                }, 'vehicle' => function ($query) {
                    $query->select('id', 'plate');
                },
                'userStart' => function ($query) {
                    $query->select('id', 'name');
                },
                'userEnd' => function ($query) {
                    $query->select('id', 'name');
                },
                'statePendingTask' => function ($query) {
                    $query->select('id', 'name');
                },
                'groupTask' => function ($query) {
                    $query->select('id', 'created_at');
                },
                'reception' => function ($query) {
                    $query->select('id', 'campa_id','created_at')
                    ->with(array(
                        'campa' => function ($query) {
                            $query->select('id', 'name');
                        }
                    ));
                }
            ))
            ->filter($request->all())
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->paginate($request->input('per_page'));
    }

    public function getById($request, $id)
    {
        $pending_task = PendingTask::with($this->getWiths($request->with))
            ->findOrFail($id);
        return ['pending_task' => $pending_task];
    }

    public function getPendingOrNextTask($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        if ($user->workshop_id != null) {
            return PendingTask::with($this->getWiths($request->with))
                ->filter($request->all())
                ->pendingOrInProgress()
                ->where('approved', true)
                ->get();
        }
        if ($user['type_user_app_id'] == null && ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3)) {
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

    public function getPendingOrNextTaskByRole($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        return PendingTask::with($this->getWiths($request->with))
            ->byCampas($user->campas->pluck('id')->toArray())
            ->filter($request->all())
            ->pendingOrInProgress()
            ->where('approved', true)
            ->get();
    }

    public function create($request)
    {
        return PendingTask::create($request->all());
    }

    public function finishAll($request)
    {
        $pending_task_ids = $request->input('pending_task_ids');
        PendingTask::whereIn($pending_task_ids)->updated([
            'state_pending_task_id' => StatePendingTask::FINISHED
        ]);
    }

    public function getVehicleById($vehicleId)
    {
        return Vehicle::findOrFail($vehicleId);
    }

    public function update($request, $id)
    {
        $pending_task = PendingTask::findOrFail($id);
        empty($request->state_pending_task_id) ? true : $this->isPause($request, $pending_task);
        $pending_task->update($request->all());
        if ($request->input('approved') == 0 && $pending_task->damage_id != null) {
            $this->closeDamage($pending_task->damage_id);
        }
        return ['pending_task' => $this->realignPendingTask($pending_task)];
    }

    private function isPause($request, $pending_task)
    {
        if ($request->state_pending_task_id == StatePendingTask::PENDING) {
            $pending_task->datetime_pause = new DateTime();
            $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);
            $oldOrder = $pending_task->order;
            $nextPendingTask = PendingTask::where('group_task_id', $pending_task->group_task_id)
                ->where('approved', true)
                ->whereNull('state_pending_task_id')
                ->orderBy('order', 'ASC')
                ->first();
            $pending_task->order = $nextPendingTask->order ?? $pending_task->order;
            $pending_task->state_pending_task_id = null;
            $pending_task->save();
            if ($nextPendingTask) {
                $nextPendingTask->order = $oldOrder;
                $nextPendingTask->state_pending_task_id = StatePendingTask::PENDING;
                $nextPendingTask->datetime_pending = date('Y-m-d H:i:s');
                $nextPendingTask->save();
            }
        }
    }

    private function diffDateTimes($datetime)
    {
        $datetime1 = new DateTime($datetime);
        $diference = date_diff($datetime1, new DateTime());
        $minutes = $diference->days * 24 * 60;
        $minutes += $diference->h * 60;
        $minutes += $diference->i;
        return $minutes;
    }

    private function realignPendingTask($pendingTask)
    {
        $this->vehicleRepository->newReception($pendingTask->vehicle_id);
        $reception = $pendingTask->vehicle->lastReception;
        PendingTask::where('reception_id', $reception->id)
            ->where('approved', true)
            ->where(function ($query) {
                return $query->whereNull('state_pending_task_id')
                    ->orWhere('state_pending_task_id', StatePendingTask::PENDING);
            })
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update(['state_pending_task_id' => null]);
                }
            });
        $pendingInProgress = PendingTask::where('reception_id', $reception->id)
            ->where('state_pending_task_id', StatePendingTask::IN_PROGRESS)
            ->get();
        if (count($pendingInProgress) == 0) {
            $firstPendingTask = PendingTask::where('reception_id', $reception->id)
                ->where(function ($query) {
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
            } else {
                $this->createPendingTaskCampa($pendingTask->vehicle, Task::TOCAMPA);
            }
        }
        $this->stateChangeRepository->updateSubStateVehicle($pendingTask->vehicle);
        return $pendingTask;
    }

    private function createPendingTaskCampa($vehicle, $task_id)
    {
        PendingTask::create([
            'vehicle_id' => $vehicle->id,
            'reception_id' => $vehicle->lastReception->id ?? null,
            'task_id' => $task_id,
            'campa_id' => $vehicle->campa_id,
            'state_pending_task_id' => StatePendingTask::FINISHED,
            'user_id' => Auth::id(),
            'user_start_id' => Auth::id(),
            'user_end_id' => Auth::id(),
            'group_task_id' => $vehicle->lastReception->group_task_id,
            'order' => -1,
            'duration' => 0,
            'approved' => true,
            'datetime_pending' => date('Y-m-d H:i:s'),
            'datetime_start' => date('Y-m-d H:i:s'),
            'datetime_finish' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id)
    {
        PendingTask::where('id', $id)
            ->delete();
        return ['message' => 'Pending task deleted'];
    }

    public function orderPendingTask($request)
    {
        foreach ($request->input('pending_tasks') as $pending_task) {
            PendingTask::where('id', $pending_task['id'])->update($pending_task);
        }
        $vehicle = $this->vehicleRepository->pendingOrInProgress($request->input('vehicle_id'));
        $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle);
        return response()->json(['vehicle' => $vehicle]);
    }

    public function startPendingTask($request)
    {
        $pending_task = PendingTask::with($this->getWiths($request->with))
            ->findOrFail($request->input('pending_task_id'));
        $vehicle = $this->getVehicleById($pending_task->vehicle_id);
        if ($pending_task->state_pending_task_id == StatePendingTask::PENDING) {
            $pending_task->state_pending_task_id = StatePendingTask::IN_PROGRESS;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->user_start_id = Auth::id();
            $pending_task->save();
            $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle);
            if (!is_null($vehicle->square)) {
                $this->historyLocationRepository->saveFromBack($vehicle->id, null, Auth::id());
                $this->squareRepository->freeSquare($vehicle->id);
            }
            $this->updateStateOrder($request);
            return $this->getPendingOrNextTask($request);
        } else {
            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }
    }

    private function updateStateOrder($request)
    {
        $pending_task = PendingTask::with(['task.subState.state', 'vehicle.orders'])
            ->where('id', $request->input('pending_task_id'))
            ->whereHas('vehicle.orders', function (Builder $builder) {
                return $builder->where('state_id', '<>', State::FINISHED);
            })
            ->first();
        if ($pending_task) {
            $order = $pending_task['vehicle']['orders'][count($pending_task['vehicle']['orders']) - 1];
            $updateOrder = Order::findOrFail($order['id']);
            $updateOrder->state_id = $pending_task['task']['subState']['state']['id'];
            $updateOrder->save();
        }
    }

    public function cancelPendingTask($request)
    {
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
        $pending_task->datetime_start = null;
        $pending_task->save();
        $this->pendingTaskCanceledRepository->create($request);
        return $this->getPendingOrNextTask($request);
    }

    public function finishPendingTask($request)
    {
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $vehicle = $pending_task->vehicle;
        if ($pending_task->state_pending_task_id == StatePendingTask::IN_PROGRESS) {
            $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
            $pending_task->order = -1;
            $pending_task->user_end_id = Auth::id();
            $pending_task->datetime_finish = date('Y-m-d H:i:s');
            $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);
            $pending_task->save();
            $reception = $pending_task->reception;
            if ($reception) {
                $reception->type_model_order_id = $vehicle->type_model_order_id;
                $reception->save();
            }
            if ($vehicle->sub_state_id == SubState::WORKSHOP_EXTERNAL) {
                $vehicle->sub_state_id = $pending_task->task->sub_state_id;
                $vehicle->save();
            }
            $pending_task->damage_id ? $this->closeDamage($pending_task->damage_id) : null;
            $pending_task_next = null;
            if (count($vehicle->lastGroupTask->approvedPendingTasks) > 0) {
                $pending_task_next = $vehicle->lastGroupTask->approvedPendingTasks[0];
            }
            if ($pending_task_next) {
                $pending_task_next->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task_next->datetime_pending = date('Y-m-d H:i:s');
                $pending_task_next->save();
                $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle);
                return $this->getPendingOrNextTask($request);
            } else {
                if ($vehicle->trade_state_id == TradeState::PRE_RESERVED) {
                    $this->vehicleRepository->updateTradeState($pending_task['vehicle_id'], TradeState::RESERVED); // Si no hay más tareas el estado comercial pasa a reservado (sin tareas pendientes)
                    $vehicle->ready_to_delivery = true;
                    $vehicle->save();
                }
                $this->createPendingTaskCampa($vehicle, $pending_task->task_id === Task::CHECK_BLOCKED ? Task::CHECK_RELEASE : Task::TOCAMPA);
                $force_sub_state_id = $pending_task->task_id === Task::CHECK_BLOCKED ? SubState::CHECK_RELEASE : SubState::CAMPA;
                if ($vehicle->sub_state_id === SubState::SOLICITUD_DEFLEET) {
                    $force_sub_state_id = SubState::SOLICITUD_DEFLEET;
                }
                $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle, null, $force_sub_state_id);
                return [
                    "status" => "OK",
                    "message" => "No hay más tareas"
                ];
            }
        } else {
            if ($pending_task->task_id == Task::UBICATION) {
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->order = -1;
                $pending_task->datetime_start = date('Y-m-d H:i:s');
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->user_end_id = Auth::id();
                $pending_task->save();
                $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle);
                if ($vehicle->sub_state_id !== SubState::SOLICITUD_DEFLEET) {
                    $vehicle = $this->vehicleRepository->pendingOrInProgress($pending_task['vehicle_id']);
                }
                if ($vehicle->trade_state_id == TradeState::PRE_RESERVED) {
                    $this->vehicleRepository->updateTradeState($vehicle->id, TradeState::RESERVED); //Si el vehículo ha sido pre-reservado pasa a reservado (sin tareas pendientes)
                }
                return ['message' => 'Tareas terminadas'];
            }
            return ['message' => 'La tarea no está en estado iniciada'];
        }
    }

    private function closeDamage($damageId)
    {
        $pendingTasks = PendingTask::where('damage_id', $damageId)
            ->where('approved', true)
            ->where(function ($builder) {
                return $builder->where('state_pending_task_id', '<>', StatePendingTask::FINISHED)
                    ->orWhereNull('state_pending_task_id');
            })
            ->get();
        if (count($pendingTasks) == 0) {
            $damage = Damage::findOrFail($damageId);
            $damage->update(['status_damage_id' => StatusDamage::CLOSED, 'datetime_close' => Carbon::now()]);
        }
    }

    public function getPendingTaskByStateCampa($request)
    {
        return PendingTask::with($this->getWiths($request->with))
            ->byCampas($request->input('campas'))
            ->where('state_pending_task_id', $request->input('state_pending_task_id'))
            ->get();
    }

    public function getPendingTaskByPlate($request)
    {
        return PendingTask::with($this->getWiths($request->with))
            ->byPlate($request->input('plate'))
            ->pendingOrInProgress()
            ->first();
    }

    public function getPendingTasksByPlate($request)
    {
        $vehicle = $this->vehicleRepository->getByPlate($request);
        $group = $this->groupTaskRepository->getLastByVehicle($vehicle->id);
        return PendingTask::with($this->getWiths($request->with))
            ->where('group_task_id', $group->id)
            ->where('approved', true)
            ->get();
    }

    public function addPendingTask($request)
    {
        $vehicle = $this->vehicleRepository->getById($request, $request->input('vehicle_id'));
        $pendingTasks = PendingTask::where('group_task_id', $request->input('group_task_id'))
            ->get();
        $task = $this->taskRepository->getById([], $request->input('task_id'));
        $pendingTask = new PendingTask();
        $pendingTask->task_id = $task['id'];
        $pendingTask->campa_id = $vehicle->campa_id;
        $pendingTask->vehicle_id = $request->input('vehicle_id');
        $pendingTask->group_task_id = $request->input('group_task_id');
        $pendingTask->reception_id = $vehicle->lastReception->id;
        $pendingTask->duration = $task['duration'];
        $pendingTask->order = count($pendingTasks) - 1;
        $pendingTask->user_id = Auth::id();
        $pendingTask->save();

        return ['pending_task' => $pendingTask];
    }

    public function addPendingTaskFinished($request)
    {
        $vehicle = Vehicle::with(['lastGroupTask.pendingTasks'])
            ->findOrFail($request->input('vehicle_id'));
        $task = $this->taskRepository->getById([], $request->input('task_id'));
        $pendingTask = new PendingTask();
        $pendingTask->vehicle_id = $vehicle->id;
        $pendingTask->task_id = $task->id;
        $pendingTask->campa_id = $vehicle->campa_id;
        $pendingTask->reception_id = $vehicle->lastReception->id;
        $pendingTask->state_pending_task_id = StatePendingTask::FINISHED;
        $pendingTask->group_task_id = $vehicle['lastGroupTask']['id'];
        $pendingTask->duration = $task['duration'];
        $pendingTask->order = -1;
        $pendingTask->approved = true;
        $pendingTask->status_color = 'green';
        $pendingTask->datetime_pending = date('Y-m-d');
        $pendingTask->datetime_start = date('Y-m-d');
        $pendingTask->datetime_finish = date('Y-m-d');
        $pendingTask->user_id = Auth::id();
        $pendingTask->user_start_id = Auth::id();
        $pendingTask->user_end_id = Auth::id();
        $pendingTask->save();
        return $pendingTask;
    }

    public function updatePendingTaskFromValidation($groupTask, $taskIdActual, $taskIdNew)
    {
        $pendingTask = PendingTask::where('group_task_id', $groupTask['id'])
            ->where('task_id', $taskIdActual)
            ->first();
        $pendingTask->task_id = $taskIdNew;
        $pendingTask->save();
    }

    public function approvedFalse($vehicleId)
    {
        PendingTask::where('vehicle_id', $vehicleId)
            ->where('approved', true)
            ->where(function ($query) {
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                    ->orWhereNull('state_pending_task_id');
            })
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update(['approved' => false]);
                }
            });
    }

    public function addPendingTaskFromIncidence($vehicleId, $taskId, $damage)
    {
        $task = $this->taskRepository->getById([], $taskId);
        $vehicle = Vehicle::findOrFail($vehicleId);
        $orderLastPendingTask = 0;
        if ($vehicle->lastGroupTask) {
            $totalApproved = $vehicle->lastGroupTask->approvedPendingTasks;
            if (count($totalApproved) > 0) {
                $orderLastPendingTask = $totalApproved[count($totalApproved) - 1]['order'];
            }
        }
        if ($task->need_authorization == false) {

            $this->vehicleRepository->newReception($vehicleId);
            $vehicle = Vehicle::findOrFail($vehicleId);

            $groupTask = $vehicle->lastReception->groupTask;

            if (!$vehicle->lastReception->group_task_id) {
                $vehicle->lastReception->group_task_id = $groupTask->id;
                $vehicle->lastReception->save();
            }

            $damage->group_task_id = $groupTask->id;
            $damage->save();

            PendingTask::create([
                'vehicle_id' => $vehicleId,
                'task_id' => $taskId,
                'reception_id' => $vehicle->lastReception->id,
                'campa_id' => $vehicle->campa_id,
                'group_task_id' => $damage->group_task_id,
                'state_pending_task_id' => $orderLastPendingTask > 0 ? null : StatePendingTask::PENDING,
                'datetime_pending' => $orderLastPendingTask > 0 ? null : date('Y-m-d H:i:s'),
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

    public function createTransferTask($request)
    {
        foreach ($request->input('vehicle_ids') as $id) {
            $vehicle = Vehicle::findOrFail($id);
            $task = $this->taskRepository->getById([], Task::TRANSFER);
            $groupTask = $vehicle->lastReception?->groupTask;
            if ($groupTask) {
                $groupTask->approved = 1;
                $groupTask->approved_available = 1;
            } else {
                $reception = $this->vehicleRepository->newReception($vehicle->id);
                $groupTask = $reception->groupTask;
            }
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

    public function cancelAllPendingTask($last_reception_id){
        $pendingTask = PendingTask::where('reception_id', $last_reception_id)->get();
        foreach($pendingTask as $pending){
            if($pending->state_pending_task_id !== 3){
                $pending->state_pending_task_id = 4;
                $pending->save();
            }
        }
        return;
    }
}
