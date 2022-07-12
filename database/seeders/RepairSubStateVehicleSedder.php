<?php

namespace Database\Seeders;

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
        $vehicles = Vehicle::all();
        // $vehicles = Vehicle::where('id', 3976)->get();

        Vehicle::whereNull('deleted_at')->update([
            'last_change_state' => null,
            'last_change_sub_state' => null
        ]);

        foreach ($vehicles as $key => $value) {
            $data = $this->stateChangeRepository->updateSubStateVehicle($value);
        }
        Log::debug('END REPAIR SUBSTATE VEHICLE');
    }
}
