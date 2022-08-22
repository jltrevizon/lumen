<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Request;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TradeState;
use App\Models\Vehicle;
use App\Repositories\GroupTaskRepository;
use App\Repositories\PendingTaskCanceledRepository;
use App\Repositories\Repository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvaratPendingTaskRepository extends Repository {

    public function __construct(
        TaskRepository $taskRepository,
        VehicleRepository $vehicleRepository,
        GroupTaskRepository $groupTaskRepository,
        PendingTaskCanceledRepository $pendingTaskCanceledRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->pendingTaskCanceledRepository = $pendingTaskCanceledRepository;
    }

    public function create($vehicleId){
        $tasks = $this->taskRepository->getByCompany(Company::INVARAT);
        $reception = $this->vehicleRepository->newReception($vehicleId);
        $groupTask = $reception->groupTask;
        $order = 1;
        foreach($tasks as $task){
            $pendingTask = new PendingTask();
            $pendingTask->vehicle_id = $vehicleId;
            $pendingTask->user_id = Auth::id();
            $pendingTask->task_id = $task['id'];
            $pendingTask->approved = true;
            if($order == 1) {
                $pendingTask->state_pending_task_id = StatePendingTask::PENDING;
                $pendingTask->datetime_pending = date('Y-m-d H:i:s');
            }
            $pendingTask->group_task_id = $groupTask['id'];
            $pendingTask->duration = $task['duration'];
            $pendingTask->order = $order;
            $pendingTask->save();
            $order++;
        }
        $this->stateChangeRepository->updateSubStateVehicle($groupTask->vehicle);
    }

    /**
     * Inicia una tarea.
     *
     * @param $request
     * @return bool|string[]
     */
    public function startTask($request){

        $pending_task = PendingTask::with($this->getWiths($request->with))
            ->findOrFail($request->input('pending_task_id'));

        if ($pending_task->state_pending_task_id == StatePendingTask::PENDING) {

            $pending_task->state_pending_task_id = StatePendingTask::IN_PROGRESS;
            $pending_task->datetime_start = date('Y-m-d H:i:s');
            $pending_task->user_start_id = Auth::id();

            return $pending_task->save();

        } else {

            return [
                'message' => 'La tarea no está en estado pendiente'
            ];
        }

    }

    /**
     * Cancela tarea y guarda la tarea cancelada.
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelTask($request)
    {
        $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
        $pending_task->datetime_start = null;
        $pending_task->save();

        return $this->pendingTaskCanceledRepository->create($request);

    }

    /**
     *
     * Finalizamos una tarea, comprobamos si hay proximas como pendientes para resetear la fecha.
     *
     * @param $request
     * @return bool|void
     */
    public function finishPendingTask($request)
    {

        try {

            $pending_task = PendingTask::findOrFail($request->input('pending_task_id'));
            $vehicle = $pending_task->vehicle;

            if ($pending_task->state_pending_task_id == StatePendingTask::IN_PROGRESS) {
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->order = -1;
                $pending_task->user_end_id = Auth::id();
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->total_paused += $this->diffDateTimes($pending_task->datetime_start);
                $pending_task->save();

                if (count($vehicle->lastGroupTask->approvedPendingTasks) > 0) {
                    $pending_task_next = $vehicle->lastGroupTask->approvedPendingTasks[0];

                    if ($pending_task_next) {
                        $pending_task_next->state_pending_task_id = StatePendingTask::PENDING;
                        $pending_task_next->datetime_pending = date('Y-m-d H:i:s');

                        return $pending_task_next->save();

                    }

                    return true;

                }
            }

        }catch (\Exception $e){
             Log::debug($e->getMessage()." - ".$e->getFile()." - ".$e->getLine());
             return false;
        }

    }

}
