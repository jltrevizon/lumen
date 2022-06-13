<?php

namespace App\Repositories;

use App\Models\Square;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
        $square->user_id = Auth::id();
        $square->save();
        $this->historyLocationRepository->saveFromBack($request->input('vehicle_id'), $id, Auth::id());
        return $square;
    }

    public function freeSquare($vehicleId){
        Square::where('vehicle_id', $vehicleId)
            ->chunk(200, function ($squares){
                foreach($squares as $square){
                    $square->update(['vehicle_id' => null]);
                }
            });
    }

    public function assignVehicle($street, $square, $vehicle_id){
        $squareUpdate = Square::whereHas('street', function(Builder $builder) use($street){
            return $builder->where('name', $street);
        })->where('name', $square)
        ->whereNull('vehicle_id')
        ->first();
        if($squareUpdate) {
            $squareUpdate->vehicle_id = $vehicle_id;
            $squareUpdate->save();
        }
    }

}
