<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\PendingTask;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\ReceptionRepository;
use App\Repositories\StateChangeRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Exception;

class PendingTaskAldController extends Controller
{

    public function __construct(
        TaskRepository $taskRepository,
        VehicleRepository $vehicleRepository,
        UserRepository $userRepository,
        ReceptionRepository $receptionRepository,
        StateChangeRepository $stateChangeRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
        $this->receptionRepository = $receptionRepository;
        $this->stateChangeRepository = $stateChangeRepository;
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
