<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\PendingTask;
use App\Models\GroupTask;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
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
    }

    public function createFromArray(Request $request){
        try {
            $groupTask = null;
            if ($request->input('group_task_id')) {
                $groupTask = GroupTask::findOrFail($request->input('group_task_id'));
            }
            else {
                $groupTask = $this->groupTaskRepository->create($request);
            }
            $this->createTasks($request->input('tasks'), $request->input('vehicle_id'), $groupTask->id);
            if (!$request->input('without_task_washed')) {
                $this->createTaskWashed($request->input('vehicle_id'), $groupTask, $request->input('tasks'));
            }
            $this->vehicleRepository->updateBack($request);

            $user = $this->userRepository->getById($request, Auth::id());
            $this->vehicleRepository->updateCampa($request->input('vehicle_id'), $user['campas'][0]['id']);
            $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));
            return [ 'message' => 'OK' ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    private function createTasks($tasks, $vehicleId, $groupTaskId){
        $isPendingTaskAssign = false;
        $order = 1;
        foreach($tasks as $task){
            $pending_task = new PendingTask();
            $pending_task->vehicle_id = $vehicleId;
            $taskDescription = $this->taskRepository->getById([], $task['task_id']);
            $pending_task->task_id = $task['task_id'];
            $pending_task->approved = $task['approved'];
            if($task['approved'] == true && $isPendingTaskAssign == false){
                if (!isset($task['without_state_pending_task'])) {
                    $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                }
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
                $isPendingTaskAssign = true;
            }
            $pending_task->group_task_id = $groupTaskId;
            $pending_task->duration = $taskDescription['duration'];
            if($task['approved'] == true){
                $pending_task->order = $order;
                $order++;
            }
            $pending_task->save();
        }
    }

    private function createTaskWashed($vehicle_id, $group_task, $tasks){
        $pending_task = new PendingTask();
        $pending_task->vehicle_id = $vehicle_id;
        $taskDescription = $this->taskRepository->getById([], 28);
        if(count($tasks) < 1){
            $pending_task->state_pending_task_id = StatePendingTask::PENDING;
            $pending_task->datetime_pending = date("Y-m-d H:i:s");
        }
        $pending_task->group_task_id = $group_task->id;
        $pending_task->task_id = $taskDescription['id'];
        $pending_task->duration = $taskDescription['duration'];
        $pending_task->order = 99;
        $pending_task->save();
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
