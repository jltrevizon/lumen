<?php

namespace Database\Factories;

use App\Model;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendingTaskCanceled extends Factory
{
    protected $model = PendingTaskCanceled::class;

    public function definition(): array
    {
    	return [
    	    'pending_task_id' => PendingTask::factory()->create()->id,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true)
    	];
    }
}
