<?php

namespace Database\Factories;

use App\Model;
use App\Models\DamageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageTypeFactory extends Factory
{
    protected $model = DamageType::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Tarea', 'Anotación'])
    	];
    }
}
