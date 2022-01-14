<?php

namespace App\Repositories;

use App\Mail\DamageVehicleMail;
use App\Models\Damage;
use App\Models\StatusDamage;
use Exception;
use Illuminate\Support\Facades\Auth;

class DamageRepository extends Repository {

    public function __construct(PendingTaskRepository $pendingTaskRepository, DamageVehicleMail $damageVehicleMail)
    {
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->damageVehicleMail = $damageVehicleMail;
    }

    public function index($request){
        return Damage::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderBy('severity_damage_id', 'desc')
            ->paginate($request->input('per_page'));
    }

    public function store($request){
        $damage = Damage::create($request->all());
        $damage->user_id = Auth::id();
        $damage->save();

        if ($request->input('notificable_invarat') || $request->input('notificable_taller')) {
            $this->damageVehicleMail->SendDamage($request);
        }

        return $damage;
    }

    public function update($request, $id){
        $damage = Damage::findOrFail($id);
        $damage->update($request->all());
        if($request->input('status_damage_id') == StatusDamage::APPROVED){
            $this->pendingTaskRepository->createPendingTaskFromDamage($damage);
        }
        return $damage;
    }

}
