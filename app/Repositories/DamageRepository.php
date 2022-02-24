<?php

namespace App\Repositories;

use App\Mail\DamageVehicleMail;
use App\Models\Damage;
use App\Models\StatusDamage;
use Exception;
use Illuminate\Support\Facades\Auth;

class DamageRepository extends Repository {

    public function __construct(
        PendingTaskRepository $pendingTaskRepository, 
        DamageVehicleMail $damageVehicleMail,
        DamageRoleRepository $damageRoleRepository,
        VehicleRepository $vehicleRepository,
        DamageTaskRepository $damageTaskRepository
    )
    {
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->damageVehicleMail = $damageVehicleMail;
        $this->damageRoleRepository = $damageRoleRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->damageTaskRepository = $damageTaskRepository;
    }

    public function index($request){
        return Damage::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderBy('severity_damage_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page'));
    }

    public function store($request){
        $damage = Damage::create($request->all());
        $damage->user_id = Auth::id();
        $damage->save();
        foreach($request->input('tasks') as $task){
            $this->pendingTaskRepository->addPendingTaskFromIncidence($request->input('vehicle_id'), $task);
            $this->damageTaskRepository->create($damage->id, $task);

        }
        $this->vehicleRepository->updateSubState($request->input('vehicle_id'), null);
        foreach($request->input('roles') as $role){
            $this->damageRoleRepository->create($damage->id, $role);
        }
        if ($request->input('notificable_invarat') || $request->input('notificable_taller1') || $request->input('notificable_taller2')) {
            $this->damageVehicleMail->SendDamage($request);
        }

        return $damage;
    }

    public function update($request, $id){
        $damage = Damage::findOrFail($id);
        $damage->update($request->all());
        if($request->input('status_damage_id') == StatusDamage::APPROVED && !is_null($damage['task_id'])){
            // $this->pendingTaskRepository->createPendingTaskFromDamage($damage);
        }
        return $damage;
    }

}
