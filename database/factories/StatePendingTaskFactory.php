<?php

namespace Database\Factories;

use App\Model;
use App\Models\StatePendingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatePendingTaskFactory extends Factory
{
    protected $model = StatePendingTask::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Pendiente','En Curso','Terminada'])
    	];
    }
}
