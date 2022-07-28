<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Models\GroupTask;
use App\Models\SubState;
use App\Repositories\GroupTaskRepository;
use App\Repositories\StateChangeRepository;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;


class AldController extends Controller
{

    public function __construct(
        TaskRepository $taskRepository,
        GroupTaskRepository $groupTaskRepository,
        StateChangeRepository $stateChangeRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->stateChangeRepository = $stateChangeRepository;
    }

    public function unapprovedTask(Request $request)
    {
        try {
            return Vehicle::with($this->getWiths($request->with))
                ->whereHas('lastUnapprovedGroupTask')
                ->whereHas('campa', function (Builder $builder) {
                    return $builder->where('company_id', Company::ALD);
                })
                ->filter($request->all())
                ->paginate($request->input('per_page'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function approvedTask(Request $request)
    {
        try {
            return Vehicle::with($this->getWiths($request->with))
                ->whereHas('groupTasks', function (Builder $builder) {
                    return $builder->where('approved', true);
                })
                ->whereHas('campa', function (Builder $builder) {
                    return $builder->where('company_id', Company::ALD);
                })
                ->filter($request->all())
                ->paginate($request->input('per_page'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createTaskVehiclesAvalible(Request $request)
    {
        try {
            $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
            if (!$vehicle->lastReception) {
                return $this->failResponse(['message' => 'Reception not found'], HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
            $groupTask = null;
            if ($request->input('group_task_id')) {
                $groupTask = GroupTask::findOrFail($request->input('group_task_id'));
            } else {
                $groupTask = $this->groupTaskRepository->createGroupTaskApproved($request);
            }

            $pending_task = new PendingTask();

            $tasksApproved = 0;
            if ($groupTask->approvedPendingTasks) {
                $tasksApproved = count($groupTask->approvedPendingTasks);
            }
            if ($tasksApproved == 0) {
                $pending_task->order = 1;
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
            } else {
                $pending_task->order = $tasksApproved + 1;
            }

            $pending_task->user_id = Auth::id();
            $pending_task->vehicle_id = $vehicle->id;
            $pending_task->reception_id = $vehicle->lastReception->id;
            if (is_null($vehicle->campa_id) && $vehicle->lastReception->campa) {
                $vehicle->campa_id = $vehicle->lastReception->campa->id;
                $vehicle->save();
            }
            $pending_task->task_id = $request->input('task_id');
            $pending_task->group_task_id = $groupTask->id;
            $taskDescription = $this->taskRepository->getById([], $pending_task->task_id);
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->approved = true;

            if ($request->input('state_pending_task_id') == StatePendingTask::FINISHED) {
                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
                $pending_task->datetime_start = date('Y-m-d H:i:s');
                $pending_task->datetime_finish = date('Y-m-d H:i:s');
                $pending_task->user_start_id = Auth::id();
                $pending_task->user_end_id = Auth::id();
                $pending_task->order = -1;
            }

            $pending_task->save();

            $is_pending_task = false;
            $order = 1;

            foreach ($groupTask->approvedPendingTasks as $update_pending_task) {
                if (!is_null($update_pending_task->state_pending_task_id)) {
                    $is_pending_task = true;
                }
                if (!$is_pending_task) {
                    $is_pending_task = true;
                    $update_pending_task->state_pending_task_id = StatePendingTask::PENDING;
                    $update_pending_task->datetime_pending = date('Y-m-d H:i:s');
                }
                $update_pending_task->order = $order;
                $update_pending_task->save();
                $order++;
            }

            $this->stateChangeRepository->updateSubStateVehicle($vehicle);
            return $this->createDataResponse(['data' => $pending_task], HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 400);
        }
    }
}
