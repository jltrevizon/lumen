<?php

namespace App\Repositories;

use App\Models\Square;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SquareRepository extends Repository
{

    public function __construct(HistoryLocationRepository $historyLocationRepository)
    {
        $this->historyLocationRepository = $historyLocationRepository;
    }

    public function index($request)
    {
        $query = Square::with($this->getWiths($request->with))
            ->selectRaw('*, (Select st.name from streets as st where st.id = squares.street_id) as street_name, (Select z.name from streets as st, zones as z where st.id = squares.street_id and st.zone_id = z.id) as zone_name')
            ->filter($request->all())
            ->orderBy('zone_name', 'asc')
            ->orderBy('street_name', 'asc')
            ->orderBy('name', 'asc');

        if ($request->input('per_page')) {
            return $query->paginate($request->input('per_page'));
        }

        return $query->get();
    }

    public function store($request)
    {
        $square = Square::create($request->all());
        return $square;
    }

    public function update($request, $id)
    {
        $square = Square::findOrFail($id);
        
        if ($square->vehicle_id != $request->input('vehicle_id') || !$square->vehicle_id ) {
            if ($request->input('vehicle_id')) {
                $this->freeSquare($request->input('vehicle_id'));
            } else if ($square->vehicle_id) {
                $this->historyLocationRepository->saveFromBack($square->vehicle_id, null, Auth::id());
            }
            $square->update($request->all());
            $square->user_id = Auth::id();
            $square->save();
            $this->historyLocationRepository->saveFromBack($request->input('vehicle_id'), $id, Auth::id());
        }
        
        return $square;
    }

    public function freeSquare($vehicleId)
    {
        Square::where('vehicle_id', $vehicleId)
            ->chunk(200, function ($squares) {
                foreach ($squares as $square) {
                    // $this->historyLocationRepository->saveFromBack($square->vehicle_id, null, Auth::id());
                    $square->update(['vehicle_id' => null]);
                }
            });
    }

    public function assignVehicle($street, $square, $vehicle_id)
    {
        $squareUpdate = Square::whereHas('street', function (Builder $builder) use ($street) {
            return $builder->where('name', $street);
        })->where('name', $square)
            ->whereNull('vehicle_id')
            ->first();
        if ($squareUpdate) {
            $squareUpdate->vehicle_id = $vehicle_id;
            $squareUpdate->save();
        }
    }
}
