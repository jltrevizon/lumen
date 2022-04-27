<?php

namespace Database\Factories;

use App\Model;
use App\Models\EstimatedDate;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstimatedDateFactory extends Factory
{
    protected $model = EstimatedDate::class;

    public function definition(): array
    {
    	return [
    	    'pending_task_id' => PendingTask::factory()->create()->id,
            'estimated_date' => $this->faker->dateTime,
            'reason' => $this->faker->text
    	];
    }
}
