<?php

namespace App\Repositories;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Exception;

class GroupTaskRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return GroupTask::with($this->getWiths($request->with))
                ->filter($request->all())
                ->paginate();
    }

    public function getById($request, $id){
        return GroupTask::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

    public function createWithVehicleId($vehicle_id){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicle_id;
        $group_task->approved = 0;
        $group_task->save();
        return $group_task;
    }

    public function create($request){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->input('vehicle_id');
        $group_task->questionnaire_id = $request->input('questionnaire_id');
        $group_task->approved = 0;
        $group_task->save();
        return $group_task;
    }

    public function createGroupTaskApproved($request){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->input('vehicle_id');
        $group_task->approved = 1;
        $group_task->approved_available = 1;
        $group_task->save();
        return $group_task;
    }

    public function update($request, $id){
        $group_task = GroupTask::findOrFail($id);
        $group_task->update($request->all());
        return ['group_task' => $group_task];
    }

    public function getLastByVehicle($vehicle_id){
        return GroupTask::where('vehicle_id', $vehicle_id)
                    ->orderBy('id', 'desc')
                    ->first();
    }

    public function approvedGroupTaskToAvailable($request){
        $group_task = GroupTask::findOrFail($request->input('group_task_id'));
        $group_task->approved_available = 1;
        $group_task->approved = 1;
        $group_task->datetime_approved = date('Y-m-d H:i:s');
        $group_task->save();
        return ['message' => 'Solicitud aprobada!'];
    }

    public function declineGroupTask($request){
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        $vehicle->sub_state_id = null;
        $vehicle->save();
        PendingTask::where('group_task_id', $request->input('group_task_id'))
                    ->delete();
        GroupTask::findOrFail($request->input('group_task_id'))
                    ->delete();
        return ['message' => 'Solicitud declinada!'];
    }

    public function groupTaskByQuestionnaireId($questionnaireId){
        return GroupTask::where('questionnaire_id', $questionnaireId)
            ->first();
    }
}
