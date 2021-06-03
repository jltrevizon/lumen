<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingTask;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\TaskController;
use App\Repositories\PendingTaskRepository;

class PendingTaskController extends Controller
{
    public function __construct(
        GroupTaskController $groupTaskController,
        TaskController $taskController,
        IncidenceController $incidenceController,
        VehicleController $vehicleController,
        PendingTaskRepository $pendingTaskRepository
        )
    {
        $this->groupTaskController = $groupTaskController;
        $this->taskController = $taskController;
        $this->incidenceController = $incidenceController;
        $this->vehicleController = $vehicleController;
        $this->pendingTaskRepository = $pendingTaskRepository;
    }

    public function getAll(){
        return PendingTask::all();
    }

    public function getById($id){
        return $this->pendingTaskRepository->getById($id);
    }

    public function getPendingOrNextTask(){
        return $this->pendingTaskRepository->getPendingOrNextTask();
    }

    public function create(Request $request){
        return $this->pendingTaskRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->pendingTaskRepository->update($request, $id);
    }

    public function createIncidence(Request $request){
        return $this->pendingTaskRepository->createIncidence($request);
    }

    public function resolvedIncidence(Request $request){
        return $this->pendingTaskRepository->resolvedIncidence($request);
    }

    public function delete($id){
        return $this->pendingTaskRepository->delete($id);
    }

    public function createFromArray(Request $request){
        return $this->pendingTaskRepository->createFromArray($request);
    }

    public function startPendingTask(Request $request){
        return $this->pendingTaskRepository->startPendingTask($request);
    }

    public function cancelPendingTask(Request $request){
        return $this->pendingTaskRepository->cancelPendingTask($request);
    }

    public function finishPendingTask(Request $request){
        return $this->pendingTaskRepository->finishPendingTask($request);
    }

    public function getPendingTaskByState(Request $request){
        return $this->pendingTaskRepository->getPendingTaskByState($request);
    }

    public function getPendingTaskByStateCampa(Request $request){
        return $this->pendingTaskRepository->getPendingTaskByStateCampa($request);
    }

    public function getPendingTaskByPlate(Request $request){
        return $this->pendingTaskRepository->getPendingTaskByPlate($request);
    }

    public function getPendingTasksByPlate(Request $request){
        return $this->pendingTaskRepository->getPendingTasksByPlate($request);
    }

    public function orderPendingTask(Request $request){
        return $this->pendingTaskRepository->orderPendingTask($request);
    }

}
