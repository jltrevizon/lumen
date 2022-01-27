<?php

namespace App\Repositories;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Models\StatePendingTask;
use Illuminate\Support\Facades\Auth;

use Exception;

class GroupTaskRepository extends Repository {

    public function __construct(
    )
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

    public function createGroupTaskApprovedByVehicle($vehicleId){
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicleId;
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

        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        if (is_null($vehicle->lastGroupTask)) {
            $vehicle->sub_state_id = null;
        } else {
            $count = count($vehicle->lastGroupTask->approvedPendingTasks);
            if ($count == 0) {
                $vehicle->sub_state_id = SubState::CAMPA;
            } else if ($count > 0) {
                $vehicle->sub_state_id = $vehicle->lastGroupTask->approvedPendingTasks[0]->task->sub_state_id;
            }
        }
        if (is_null($vehicle->company_id)) {
            $user = Auth::user();
            $vehicle->company_id = $user->company_id;
        }
        $vehicle->save();
    //    $this->vehicleRepository->updateSubState($request->input('vehicle_id'), null);

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
