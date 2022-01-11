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
            ->paginate($request->input('per_page'));
    }

    public function saveFromBack($vehicleId, $squareId){
        HistoryLocation::create([
            'vehicle_id' => $vehicleId,
            'square_id' => $squareId,
            'user_id' => Auth::id()
        ]);
    }

}
