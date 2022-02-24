<?php

use App\Models\PendingAuthorization;
use App\Models\StateAuthorization;
use App\Repositories\Repository;

class PendingAuthorizationRepository extends Repository {

    public function index($request){
        return PendingAuthorization::with($this->getWiths($request->with))
            ->get();
    }
    
    public function create($vehicleId, $taskId, $damageId){
        PendingAuthorization::create([
            'vehicle_id' => $vehicleId,
            'task_id' => $taskId,
            'damage_id' => $damageId,
            'state_authorization' => StateAuthorization::PENDING
        ]);
    }

}