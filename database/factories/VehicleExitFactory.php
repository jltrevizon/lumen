<?php

namespace Database\Factories;

use App\Model;
use App\Models\PendingTask;
use App\Models\Vehicle;
use App\Models\VehicleExit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleExitFactory extends Factory
{
    protected $model = VehicleExit::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'pending_task_id' => PendingTask::factory()->create()->id,
            'delivery_by' => $this->faker->name,
            'delivery_to' => $this->faker->name,
            'name_place' => $this->faker->name,
            'is_rolling' => $this->faker->randomElement([true, false]),
            'date_delivery' => $this->faker->date
    	];
    }
}
