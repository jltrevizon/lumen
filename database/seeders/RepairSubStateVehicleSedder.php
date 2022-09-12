<?php

namespace Database\Seeders;

use App\Models\SubState;
use App\Models\Vehicle;
use App\Repositories\StateChangeRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RepairSubStateVehicleSedder extends Seeder
{
    public function __construct(StateChangeRepository $stateChangeRepository)
    {
        $this->stateChangeRepository = $stateChangeRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::debug('BIGIN REPAIR SUBSTATE VEHICLE');
        $vehicles = Vehicle::whereNotIn('sub_state_id', [
            SubState::ALQUILADO,
            SubState::WORKSHOP_EXTERNAL,
            SubState::SOLICITUD_DEFLEET,
            SubState::TRANSIT
        ])->get();
        // $vehicles = Vehicle::where('id', 1497)->get();

        foreach ($vehicles as $key => $value) {
            $data = $this->stateChangeRepository->updateSubStateVehicle($value);
        }
        Log::debug('END REPAIR SUBSTATE VEHICLE');
    }
}
