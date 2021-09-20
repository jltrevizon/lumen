<?php

namespace App\Repositories;

use App\Models\Reception;
use App\Models\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReceptionRepository {

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){
        $user = $this->userRepository->getById([], Auth::id());
        $reception = new Reception();
        $reception->campa_id = $user->campas->pluck('id')->toArray()[0];
        $reception->vehicle_id = $request->input('vehicle_id');
        $reception->has_accessories = false;
        $reception->save();
        return ['reception' => $reception];
    }

    public function getById($id){
        $reception = Reception::with(['vehicle.vehicleModel.brand','vehicle.subState.state'])
                        ->findOrFail($id);
        return ['reception' => $reception];
    }

    public function lastReception($vehicle_id){
        return Reception::where('vehicle_id', $vehicle_id)
                ->orderBy('id', 'DESC')
                ->first();
    }

    public function update($reception_id){
        $reception = Reception::findOrFail($reception_id);
        $reception->has_accessories = true;
        $reception->save();
        return $reception;
    }

}
