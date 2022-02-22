<?php

namespace Database\Factories;

use App\Model;
use App\Models\IncidenceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidenceTypeFactory extends Factory
{
    protected $model = IncidenceType::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Tarea', 'Anotación'])
    	];
    }
}
