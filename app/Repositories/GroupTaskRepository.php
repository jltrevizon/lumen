<?php

namespace App\Repositories;

use App\Mail\NotificationDAMail;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Vehicle;
use App\Models\StatePendingTask;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupTaskRepository extends Repository
{

    public function __construct(
        StateChangeRepository $stateChangeRepository,
        NotificationDAMail $notificationDAMail
    ) {
        $this->stateChangeRepository = $stateChangeRepository;
        $this->notificationDAMail = $notificationDAMail;
    }

    public function getAll($request)
    {
        return GroupTask::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate();
    }

    public function getById($request, $id)
    {
        return GroupTask::with($this->getWiths($request->with) ?? [])
            ->findOrFail($id);
    }

    public function create($data)
    {
        $group_task = new GroupTask();
        $group_task->vehicle_id = $data['vehicle_id'];
        $group_task->questionnaire_id = $data['questionnaire_id'] ?? null;
        $group_task->approved_available = $data['approved_available'] ?? 0;
        $group_task->approved = $data['approved'] ?? 0;
        $group_task->save();
        return $group_task;
    }

    public function update($request, $id)
    {
        $group_task = GroupTask::findOrFail($id);
        $group_task->update($request->all());
        return ['group_task' => $group_task];
    }

    public function getLastByVehicle($vehicle_id)
    {
        return GroupTask::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function approvedGroupTaskToAvailable($request)
    {
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        $group_task = $vehicle->lastReception?->groupTask;

        if (!is_null($group_task)) {

            $group_task->approved_available = true;
            $group_task->approved = true;
            $group_task->datetime_approved = Carbon::now();

            if ($request->input('questionnaire_id')) {
                $group_task->questionnaire_id = $request->input('questionnaire_id');
            }
            $group_task->save();
            $data_update =  [
                'group_task_id' => $group_task->id,
                'state_pending_task_id' => StatePendingTask::FINISHED,
                'user_id' => Auth::id(),
                'user_start_id' => Auth::id(),
                'user_end_id' => Auth::id(),
                'duration' => 0,
                'approved' => true,
                'datetime_finish' => Carbon::now(),
                'campa_id' => $vehicle->campa_id,
                'order' => -1
            ];
            $pendingTask = PendingTask::updateOrCreate([
                'reception_id' => $vehicle->lastReception->id,
                'task_id' => Task::VALIDATE_CHECKLIST,
                'vehicle_id' => $vehicle->id
            ], $data_update);
            if (is_null($pendingTask->datetime_pending)) {
                $pendingTask->datetime_pending = Carbon::now();
            }
            if (is_null($pendingTask->datetime_start)) {
                $pendingTask->datetime_start = Carbon::now();
            }
            $pendingTask->save();
            $pendingTask = PendingTask::updateOrCreate([
                'reception_id' => $vehicle->lastReception->id,
                'task_id' => Task::TOCAMPA,
                'vehicle_id' => $vehicle->id
            ], $data_update);
            if (is_null($pendingTask->datetime_pending)) {
                $pendingTask->datetime_pending = Carbon::now();
            }
            if (is_null($pendingTask->datetime_start)) {
                $pendingTask->datetime_start = Carbon::now();
            }
            $pendingTask->save();
            $count = count($vehicle->lastReception->approvedPendingTasks);
            if ($count > 0) {
                $pendingtTask = PendingTask::findOrFail($vehicle->lastReception->approvedPendingTasks[0]->id);
                $pendingtTask->state_pending_task_id = StatePendingTask::PENDING;
                $pendingtTask->datetime_pending = Carbon::now();
                $pendingtTask->save();
            }
        }
        if (is_null($vehicle->company_id)) {
            $user = Auth::user();
            $vehicle->company_id = $user->company_id;
            $vehicle->save();
        }
        if ($vehicle->has_environment_label == false) {
            $this->notificationDAMail->build($vehicle->id);
        }
        $vehicle = $this->stateChangeRepository->updateSubStateVehicle($vehicle);
        return response()->json([
            'message' => 'Solicitud aprobada!',
            'vehicle' => $vehicle
        ]);
    }

    public function declineGroupTask($request)
    {
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        PendingTask::where('reception_id',  $vehicle->lastReception->id)
            ->delete();
        $this->stateChangeRepository->updateSubStateVehicle($vehicle);
        return ['message' => 'Solicitud declinada!'];
    }

    public function groupTaskByQuestionnaireId($questionnaireId)
    {
        return GroupTask::where('questionnaire_id', $questionnaireId)
            ->first();
    }


}
