<?php

namespace Database\Factories;

use App\Model;
use App\Models\SubState;
use App\Models\SubStateChangeHistory;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubStateChangeHistoryFactory extends Factory
{
    protected $model = SubStateChangeHistory::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'sub_state_id' => SubState::factory()->create()->id
    	];
    }
}
