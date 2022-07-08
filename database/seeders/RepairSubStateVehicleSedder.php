<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Repositories\StateChangeRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RepairSubStateVehicleSedder extends Seeder
{
    public function __construct(StateChangeRepository $stateChangeRepository) {
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
        $vehicles = Vehicle::all();
        foreach ($vehicles as $key => $value) {
           // Log::debug($value->lastGroupTask->approved_available);
            $data = $this->stateChangeRepository->updateSubStateVehicle($value);
           // Log::debug($data->sub_state_id);
        }
        Log::debug('END REPAIR SUBSTATE VEHICLE');
    }
}
