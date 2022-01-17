<?php

namespace App\Repositories;

use App\Models\Square;

class SquareRepository extends Repository {

    public function __construct(HistoryLocationRepository $historyLocationRepository)
    {
        $this->historyLocationRepository = $historyLocationRepository;
    }

    public function index($request){
        return Square::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function store($request){
        $square = Square::create($request->all());
        return $square;
    }

    public function update($request, $id){
        if($request->input('vehicle_id')) $this->freeSquare($request->input('vehicle_id'));
        $square = Square::findOrFail($id);
        $square->update($request->all());
        $this->historyLocationRepository->saveFromBack($request->input('vehicle_id'), $id, $request->input('user_id'));
        return $square;
    }

    private function freeSquare($vehicleId){
        Square::where('vehicle_id', $vehicleId)
            ->chunk(200, function ($squares){
                foreach($squares as $square){
                    $square->update(['vehicle_id' => null]);
                }
            });
    }

}
