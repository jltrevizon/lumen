<?php

namespace App\Repositories;

use App\Mail\DamageVehicleMail;
use App\Mail\NotificationMail;
use App\Models\Damage;
use App\Models\StatusDamage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DamageRepository extends Repository {

    public function __construct(
        PendingTaskRepository $pendingTaskRepository, 
        DamageVehicleMail $damageVehicleMail,
        DamageRoleRepository $damageRoleRepository,
        VehicleRepository $vehicleRepository,
        DamageTaskRepository $damageTaskRepository,
        NotificationMail $notificationMail,
    )
    {
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->damageVehicleMail = $damageVehicleMail;
        $this->damageRoleRepository = $damageRoleRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->damageTaskRepository = $damageTaskRepository;
        $this->notificationMail = $notificationMail;
    }

    public function index($request){
        return Damage::with($this->getWiths($request->with))
            ->withTrashed()
            ->filter($request->all())
            ->orderBy('severity_damage_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page'));
    }

    public function store($request){
        $damage = Damage::create($request->all());
        $damage->user_id = Auth::id();
        $damage->save();

        $vehicleWithOldPendingTask = $this->vehicleRepository->pendingOrInProgress($request->input('vehicle_id'));

        foreach($request->input('tasks') as $task){
            $this->pendingTaskRepository->addPendingTaskFromIncidence($request->input('vehicle_id'), $task, $damage);
            $this->damageTaskRepository->create($damage->id, $task);
        }

        $vehicle = $this->vehicleRepository->pendingOrInProgress($request->input('vehicle_id'));

        $this->vehicleRepository->updateSubState($request->input('vehicle_id'), $vehicleWithOldPendingTask?->lastGroupTask?->pendingTasks[0], $vehicle?->lastGroupTask?->pendingTasks[0]);
        
        foreach($request->input('roles') as $role){
            $this->damageRoleRepository->create($damage->id, $role);
            $this->notificationMail->build($role, $damage->id);
        }

        $groupTask = $damage->vehicle->lastGroupTask;

        if($groupTask){
            $damage->group_task_id = $groupTask->id;
            $damage->save();
        }

        return $damage;
    }

    public function update($request, $id){
        $damage = Damage::findOrFail($id);
        $damage->update($request->all());
        $damage->datetime_close = Carbon::now();
        $damage->save();
        return $damage;
    }

}
