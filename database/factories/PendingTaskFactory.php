<?php

namespace Database\Factories;

use App\Model;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendingTaskFactory extends Factory
{
    protected $model = PendingTask::class;

    public function definition(): array
    {
    	return [
            'vehicle_id' => Vehicle::factory()->create()->id,
            'task_id' => Task::factory()->create()->id,
            'state_pending_task_id' => StatePendingTask::factory()->create()->id,
            'group_task_id' => GroupTask::factory()->create()->id,
            'duration' => $this->faker->randomNumber($nbDigits = 2, $strict = false),
            'order' => $this->faker->randomNumber($nbDigits = 1, $strict = false),
            'code_authorization' => $this->faker->numerify('#######'),
            'status_color' => $this->faker->randomElement(['Green','Yellow','Red']),
            'datetime_pending' => $this->faker->dateTime,
            'datetime_start' => $this->faker->dateTime,
            'datetime_finish' => $this->faker->dateTime
    	];
    }
}
