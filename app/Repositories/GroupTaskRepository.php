<?php

namespace App\Repositories;

use App\Mail\NotificationDAMail;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Models\StatePendingTask;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function createWithVehicleId($vehicle_id)
    {
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicle_id;
        $group_task->approved = 0;
        $group_task->save();
        return $group_task;
    }

    public function create($request)
    {
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->input('vehicle_id');
        $group_task->questionnaire_id = $request->input('questionnaire_id');
        $group_task->approved = 0;
        $group_task->save();
        return $group_task;
    }

    public function createGroupTaskApproved($request)
    {
        $group_task = new GroupTask();
        $group_task->vehicle_id = $request->input('vehicle_id');
        $group_task->approved = 1;
        $group_task->approved_available = 1;
        $group_task->save();
        return $group_task;
    }

    public function createGroupTaskApprovedByVehicle($vehicleId)
    {
        $group_task = new GroupTask();
        $group_task->vehicle_id = $vehicleId;
        $group_task->approved = 1;
        $group_task->approved_available = 1;
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
        $group_task = GroupTask::findOrFail($request->input('group_task_id'));
        $group_task->approved_available = true;
        $group_task->approved = true;
        $group_task->datetime_approved = Carbon::now();
        $group_task->save();

        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        if (!is_null($vehicle->lastGroupTask)) {
            $data_update =  [
                'reception_id' => $vehicle->lastReception->id ?? null,
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
                'group_task_id' => $group_task->id,
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
                'group_task_id' => $group_task->id,
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
            $count = count($vehicle->lastGroupTask->approvedPendingTasks);
            if ($count > 1) {
                $pendingtTask = PendingTask::findOrFail($vehicle->lastGroupTask->approvedPendingTasks[0]->id);
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
        PendingTask::where('group_task_id', $request->input('group_task_id'))
            ->delete();
        GroupTask::findOrFail($request->input('group_task_id'))
            ->delete();
        $this->stateChangeRepository->updateSubStateVehicle($vehicle);
        return ['message' => 'Solicitud declinada!'];
    }

    public function groupTaskByQuestionnaireId($questionnaireId)
    {
        return GroupTask::where('questionnaire_id', $questionnaireId)
            ->first();
    }

    public function disablePendingTasks($group_task)
    {
        $pendingTasks = PendingTask::where('group_task_id', $group_task->id)
            ->whereNotNull('order')
            ->count();

        PendingTask::where('group_task_id', $group_task->id)
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update([
                        'approved' => false
                    ]);
                }
            });
        $groupTask = GroupTask::findOrFail($group_task->id);
        $groupTask->approved = true;
        $groupTask->approved_available = true;
        $groupTask->datetime_defleeting = Carbon::now();
        $groupTask->save();

        $pendingTask = new PendingTask();
        $pendingTask->vehicle_id = $group_task->vehicle_id;
        $pendingTask->task_id = Task::UBICATION;
        $pendingTask->state_pending_task_id = StatePendingTask::PENDING;
        $pendingTask->group_task_id = $group_task->id;
        $pendingTask->duration = 1;
        $pendingTask->order = $pendingTasks + 1;
        $pendingTask->datetime_pending = Carbon::now();
        $pendingTask->user_id = Auth::id();
        $pendingTask->save();
    }

    public function enablePendingTasks($group_task)
    {
        PendingTask::where('group_task_id', $group_task->id)
            ->where('task_id', Task::UBICATION)
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update([
                        'approved' => false,
                        'order' => null,
                        'state_pending_task_id' => null,
                    ]);
                }
            });

        PendingTask::where('group_task_id', $group_task->id)
            ->whereNotNull('order')
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update([
                        'approved' => true
                    ]);
                }
            });

        $groupTask = GroupTask::findOrFail($group_task->id);
        $groupTask->approved = false;
        $groupTask->approved_available = false;
        $groupTask->datetime_defleeting = null;
        $groupTask->save();
        $this->orderPendingTask($groupTask);
    }

    private function orderPendingTask($group_task)
    {
        $pendingTask = PendingTask::where('group_task_id', $group_task->id)
            ->orderBy('order', 'ASC')
            ->first();
        $pendingTask->state_pending_task_id = StatePendingTask::PENDING;
        $pendingTask->datetime_pending = Carbon::now();
        $pendingTask->save();
    }
}
