<?php

namespace Database\Factories;

use App\Model;
use App\Models\Incidence;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidenceFactory extends Factory
{
    protected $model = Incidence::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'resolved' => $this->faker->randomElement([true, false])
    	];
    }
}
