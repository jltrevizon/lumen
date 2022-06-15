<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\PendingTask;
use App\Models\GroupTask;
use App\Models\Role;
use App\Models\StateChange;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\AccessoryRepository;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\GroupTaskRepository;
use App\Repositories\ReceptionRepository;
use App\Repositories\StateChangeRepository;
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
        StateChangeRepository $stateChangeRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
        $this->receptionRepository = $receptionRepository;
        $this->stateChangeRepository = $stateChangeRepository;
    }

    public function createFromArray(Request $request){
        try {
            $this->finishPendingTaskLastGroupTask($request->input('vehicle_id'));
            $groupTask = null;
            if ($request->input('group_task_id')) {
                $groupTask = GroupTask::findOrFail($request->input('group_task_id'));
            }
            else {
                $groupTask = $this->groupTaskRepository->create($request);
                $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));
                $reception->group_task_id = $groupTask->id;
                $reception->save();
            }
            $user = $this->userRepository->getById($request, Auth::id());
            $this->vehicleRepository->updateCampa($request->input('vehicle_id'), $user['campas'][0]['id']);

            $this->createTasks($request->input('tasks'), $request->input('vehicle_id'), $groupTask->id);
            $this->vehicleRepository->updateBack($request);

            return [ 'message' => 'OK' ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    private function finishPendingTaskLastGroupTask($vehicleId){
        $vehicle = Vehicle::findOrFail($vehicleId);
            $pendingTasks = $vehicle->lastGroupTask->pendingTasks ?? null;
            if($pendingTasks) {
                foreach ($pendingTasks as $key => $pending_task) {
                    $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                    $pending_task->order = -1;
                    if (is_null($pending_task->datetime_pending)) {
                        $pending_task->datetime_pending = date('Y-m-d H:i:s');
                    }
                    if (is_null($pending_task->datetime_start)) {                                
                        $pending_task->datetime_start = date('Y-m-d H:i:s');
                    }
                    if (is_null($pending_task->datetime_finish)) {
                        $pending_task->datetime_finish = date('Y-m-d H:i:s');                                
                    }
                    if (is_null($pending_task->user_start_id)) {
                        $pending_task->user_start_id = Auth::id();
                    }
                    if (is_null($pending_task->user_end_id)) {
                        $pending_task->user_end_id = Auth::id();
                    }
                    $pending_task->save();
                }   
            }
    }

    private function createTasks($tasks, $vehicleId, $groupTaskId){
        $user = User::where('role_id', Role::CONTROL)
            ->first();
        $vehicle = Vehicle::findOrFail($vehicleId);
        $isPendingTaskAssign = false;
        $order = 1;
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $pending_task->reception_id = $vehicle->lastReception->id;
            $pending_task->campa_id = $vehicle->campa_id;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = $task['approved'];
            $pending_task->created_from_checklist = true;
            if($task['approved'] == true && $isPendingTaskAssign == false){
                if (!isset($task['without_state_pending_task'])) {
                    $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                }
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
                $isPendingTaskAssign = true;
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->user_id = $user->id;
            $pending_task->duration = $taskDescription['duration'];
            if($task['approved'] == true){
                $pending_task->order = $order;
                $order++;
            }
            $pending_task->save();
            if($pending_task->state_pending_task_id == StatePendingTask::PENDING){
                $this->stateChangeRepository->createOrUpdate($vehicleId, $pending_task, $pending_task);
            }
        }
    }

    public function updatePendingTask(Request $request){
        try {
            $pending_task = PendingTask::where('vehicle_id', $request->input('vehicle_id'))
                                ->where('task_id', $request->input('task_id'))
                                ->orderBy('id', 'DESC')
                                ->first();
            $pending_task->approved = $request->input('approved');
            $pending_task->save();
            return response()->json(['pending_task' => $pending_task], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
