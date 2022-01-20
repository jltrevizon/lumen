<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\SubState;

class RepairSubStateVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
    	$sub_state_ids = [10, 11, 12, 1, 2];


        $vehicles = Vehicle::whereHas('lastGroupTask', function($query) { 
        	return $query->whereDoesntHave('allPendingTasks');
        })->get('id');
        $ids = collect($vehicles)->map(function ($item){ return $item->id;})->toArray();
        

        Vehicle::whereNotIn('sub_state_id', $sub_state_ids)->whereIn('id', $ids)->update(['sub_state_id' => null]);
        
        Vehicle::whereNotIn('sub_state_id', $sub_state_ids)->whereHas('lastGroupTask.allPendingTasks')->whereNotIn('id', $ids)->update(['sub_state_id' => 1]);
        
        Vehicle::whereIn('sub_state_id', $sub_state_ids)->whereDoesntHave('lastGroupTask')->update(['sub_state_id' => null]);
        */

        $vehicles = Vehicle::with('lastGroupTask.approvedPendingTasks')->get();
        foreach ($vehicles as $key => $vehicle) {
            if (is_null($vehicle->lastGroupTask)) {
                $vehicle->sub_state_id = null;
            } else {
                if (count($vehicle->lastGroupTask->approvedPendingTasks) === 0) {
                    $vehicle->sub_state_id = null;
                } else if ($vehicle->sub_state_id != SubState::ALQUILADO && $vehicle->sub_state_id != SubState::WORKSHOP_EXTERNAL) {
                    $vehicle->sub_state_id = $vehicle->lastGroupTask->approvedPendingTasks[0]->task->sub_state_id;
                }
            }
            $vehicle->save();
        }
    }
}
