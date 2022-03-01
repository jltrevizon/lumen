<?php

namespace Database\Factories;

use App\Model;
use App\Models\StateAuthorization;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateAuthorizationFactory extends Factory
{
    protected $model = StateAuthorization::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Pendiente','Aprobado','Rechazado'])
    	];
    }
}
