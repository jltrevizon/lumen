<?php

namespace Database\Factories;

use App\Model;
use App\Models\Request;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskReservationFactory extends Factory
{
    protected $model = TaskReservationFactory::class;

    public function definition(): array
    {
    	return [
    	    'request_id' => Request::factory()->create()->id,
            'task_id' => Task::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id,
            'order' => $this->faker->randomNumber($nbDigits = 2, $strict = false)
    	];
    }
}
