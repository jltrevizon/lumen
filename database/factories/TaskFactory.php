<?php

namespace Database\Factories;

use App\Model;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
    	return [
    	    'sub_state_id' => SubState::factory()->create()->id,
            'type_task_id' => TypeTask::factory()->create()->id,
            'name' => $this->faker->text,
            'duration' => $this->faker->randomNumber($nbDigits = 2, $strict = false)
    	];
    }
}
