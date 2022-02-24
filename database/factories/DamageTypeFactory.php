<?php

namespace Database\Factories;

use App\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageTypeFactory extends Factory
{
    protected $model = DamageFactory::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Tarea', 'Anotación'])
    	];
    }
}
