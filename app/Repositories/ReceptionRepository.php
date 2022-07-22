<?php

namespace App\Repositories;

use App\Console\Commands\StateChanges;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\Request;
use App\Models\SubState;
use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceptionRepository extends Repository
{

    public function __construct(
        UserRepository $userRepository,
        VehiclePictureRepository $vehiclePictureRepository,
        VehicleRepository $vehicleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->vehiclePictureRepository = $vehiclePictureRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function index($request)
    {
        ini_set("memory_limit", "-1");
        return Reception::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function create($request)
    {
        $receptionDuplicate = Reception::where('vehicle_id', $request->input('vehicle_id'))
            ->whereDate('created_at', date('Y-m-d'))
            ->first();

        if($receptionDuplicate){

            $this->vehiclePictureRepository->deletePictureByReception($receptionDuplicate);

        }

        Reception::where('vehicle_id', $request->input('vehicle_id'))
            ->whereDate('created_at', date('Y-m-d'))
            ->delete();

        $user = $this->userRepository->getById([], Auth::id());
        $reception = new Reception();
        $reception->campa_id = $user->campas->pluck('id')->toArray()[0];
        $reception->vehicle_id = $request->input('vehicle_id');
        $reception->finished = false;
        $reception->has_accessories = false;
        $reception->save();
    }

    public function newReception($vehicle_id)
    {
        $user = $this->userRepository->getById([], Auth::id());
        $reception = new Reception();
        $reception->campa_id = $user->campas->pluck('id')->toArray()[0];
        $reception->vehicle_id = $vehicle_id;
        $reception->finished = false;
        $reception->has_accessories = false;
        $reception->save();
        return $reception;
    }

    public function getById($id)
    {
        $reception = Reception::with(['vehicle.vehicleModel.brand', 'vehicle.subState.state'])
            ->findOrFail($id);
        return ['reception' => $reception];
    }

    public function lastReception($vehicle_id)
    {
        return Reception::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'DESC')
            ->first();
    }

    public function update($reception_id)
    {
        $reception = Reception::findOrFail($reception_id);
        $reception->has_accessories = true;
        $reception->save();
        return $reception;
    }

    public function updateReception($request, $id)
    {
        $reception = Reception::findOrFail($id);
        $reception->update($request->all());
        return $reception;
    }
}
