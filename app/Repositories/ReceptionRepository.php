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
        VehicleRepository $vehicleRepository,
        GroupTaskRepository $groupTaskRepository
    ) {
        $this->userRepository = $userRepository;
        $this->vehiclePictureRepository = $vehiclePictureRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->groupTaskRepository = $groupTaskRepository;
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

        $reception = new Reception();
        $campa = Auth::user()->campas->first();
        if (!is_null($campa)) {
            $reception->campa_id = $campa->id;
        }
        $reception->vehicle_id = $request->input('vehicle_id');
        $reception->finished = false;
        $reception->has_accessories = false;


        $group_task = $this->groupTaskRepository->create([
            'vehicle_id' => $request->input('vehicle_id'),
            'approved_available' => true,
            'approved' => true
        ]);
        $group_task_id = $group_task->id;
        $reception->group_task_id = $group_task_id;

        $reception->save();
        if (is_null($reception->vehicle->campa_id)) {
            $reception->vehicle->campa_id = $campa->campa_id;
            $reception->vehicle->save();
        }
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
