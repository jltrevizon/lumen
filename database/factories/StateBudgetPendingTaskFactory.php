<?php

namespace Database\Factories;

use App\Model;
use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateBudgetPendingTaskFactory extends Factory
{
    protected $model = StateBudgetPendingTask::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Pendiente', 'Aprobado', 'Declinado'])
    	];
    }
}
