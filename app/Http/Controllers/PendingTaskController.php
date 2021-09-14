<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingTask;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\TaskController;
use App\Repositories\PendingTaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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

    public function getAll(Request $request){
        return $this->getDataResponse($this->pendingTaskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->pendingTaskRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function getPendingOrNextTask(Request $request){
        return $this->getDataResponse($this->pendingTaskRepository->getPendingOrNextTask($request));
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'task_id' => 'required|integer',
            'group_task_id' => 'required|integer',
            'duration' => 'required',
            'order' => 'required|integer'
        ]);

        return $this->createDataResponse($this->pendingTaskRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function pendingTasksFilter(Request $request){
        return $this->getDataResponse($this->pendingTaskRepository->pendingTasksFilter($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->pendingTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function createIncidence(Request $request){

        $this->validate($request, [
            'pending_task_id' => 'required|integer'
        ]);

        return $this->createDataResponse($this->pendingTaskRepository->createIncidence($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function resolvedIncidence(Request $request){

        $this->validate($request, [
            'pending_task_id' => 'required|integer'
        ]);

        return $this->updateDataResponse($this->pendingTaskRepository->resolvedIncidence($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->pendingTaskRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

    public function startPendingTask(Request $request){

        $this->validate($request, [
            'pending_task_id' => 'required|integer'
        ]);

        return $this->updateDataResponse($this->pendingTaskRepository->startPendingTask($request), HttpFoundationResponse::HTTP_OK);
    }

    public function cancelPendingTask(Request $request){

        $this->validate($request, [
            'pending_task_id' => 'required|integer'
        ]);

        return $this->updateDataResponse($this->pendingTaskRepository->cancelPendingTask($request), HttpFoundationResponse::HTTP_OK);
    }

    public function finishPendingTask(Request $request){

        $this->validate($request, [
            'pending_task_id' => 'required|integer'
        ]);

        return $this->updateDataResponse($this->pendingTaskRepository->finishPendingTask($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getPendingTaskByStateCampa(Request $request){

        $this->validate($request, [
            'campas' => 'required',
            'state_pending_task_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->pendingTaskRepository->getPendingTaskByStateCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getPendingTaskByPlate(Request $request){

        $this->validate($request, [
            'plate' => 'required|string'
        ]);

        return $this->getDataResponse($this->pendingTaskRepository->getPendingTaskByPlate($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getPendingTasksByPlate(Request $request){
        return $this->getDataResponse($this->pendingTaskRepository->getPendingTasksByPlate($request), HttpFoundationResponse::HTTP_OK);
    }

    public function orderPendingTask(Request $request){

        $this->validate($request, [
            'pending_tasks' => 'required',
            'vehicle_id' => 'required|integer'
        ]);

        return $this->pendingTaskRepository->orderPendingTask($request);
    }

    public function addPendingTask(Request $request){
        return $this->createDataResponse($this->pendingTaskRepository->addPendingTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function addPendingTaskFinished(Request $request){
        return $this->createDataResponse($this->pendingTaskRepository->addPendingTaskFinished($request), HttpFoundationResponse::HTTP_CREATED);
    }

}
