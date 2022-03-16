<?php

namespace App\Repositories;

use App\Models\SubStateChangeHistory;

class SubStateChangeHistoryRepository extends Repository {

    public function store($vehicleId, $subStateId){
        $subStateChangeHistory = SubStateChangeHistory::where('vehicle_id', $vehicleId)
            ->orderBy('id', 'DESC')
            ->first();
        if($subStateChangeHistory && $subStateChangeHistory->sub_state_id != $subStateId){
            SubStateChangeHistory::create([
                'vehicle_id' => $vehicleId,
                'sub_state_id' => $subStateId
            ]);
        }
        
    }

}
