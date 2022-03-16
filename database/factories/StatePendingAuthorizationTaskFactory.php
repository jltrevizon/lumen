<?php

namespace Database\Factories;

use App\Model;
use App\Models\StatePendingAuthorizationTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatePendingAuthorizationTaskFactory extends Factory
{
    protected $model = StatePendingAuthorizationTask::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Pendiente','Aprobada','Rechazada'])
    	];
    }
}
