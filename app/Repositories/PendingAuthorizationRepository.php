<?php

namespace App\Repositories;

use App\Models\PendingAuthorization;
use App\Models\PendingTask;
use App\Models\StateAuthorization;
use App\Models\StatePendingTask;
use App\Models\Vehicle;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingAuthorizationRepository extends Repository
{

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index($request)
    {
        return PendingAuthorization::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function create($vehicleId, $taskId, $damageId)
    {
        PendingAuthorization::create([
            'vehicle_id' => $vehicleId,
            'task_id' => $taskId,
            'damage_id' => $damageId,
            'state_authorization' => StateAuthorization::PENDING
        ]);
    }

}
