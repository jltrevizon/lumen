<?php

namespace App\Repositories;

use App\Models\HistoryLocation;
use App\Models\Square;
use Aws\History;
use Illuminate\Support\Facades\Auth;


class HistoryLocationRepository extends Repository {

    public function index($request){
        return HistoryLocation::with($this->getWiths($request->with))
            ->filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page'));
    }

    public function saveFromBack($vehicleId, $squareId, $userId){
        $history = HistoryLocation::create([
            'vehicle_id' => $vehicleId,
            'square_id' => $squareId,
            'user_id' => $userId
        ]);
        $vehicle = $history->vehicle;
        $history->reception_id = $vehicle->lastReception->id;
        $history->save();
    }

}
