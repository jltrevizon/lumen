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
        StateChangeRepository $stateChangeRepository,
        GroupTaskRepository $groupTaskRepository
    )
    {
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->damageVehicleMail = $damageVehicleMail;
        $this->damageRoleRepository = $damageRoleRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->damageTaskRepository = $damageTaskRepository;
        $this->notificationMail = $notificationMail;
        $this->stateChangeRepository = $stateChangeRepository;
        $this->groupTaskRepository = $groupTaskRepository;
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
        $damage->vehicle_id = $request->input('vehicle_id');
        $damage->save();
        
        $vehicle = $damage->vehicle;
        
        $damage->save();

        $isDamageTask = false;

        foreach($request->input('tasks') as $task){
            $this->pendingTaskRepository->addPendingTaskFromIncidence($damage->vehicle_id, $task, $damage);
            $this->damageTaskRepository->create($damage->id, $task);
            $isDamageTask = true;
        }

        $vehicle = $this->vehicleRepository->pendingOrInProgress($request->input('vehicle_id'));
        if($isDamageTask) { 
            $this->stateChangeRepository->updateSubStateVehicle($vehicle);         
        }
        
        foreach($request->input('roles') as $role){
            $this->damageRoleRepository->create($damage->id, $role);
            if(env('APP_ENV') == 'production') {
                $this->notificationMail->build($role, $damage->id);
            }
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
