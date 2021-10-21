<?php

namespace Database\Factories;

use App\Model;
use App\Models\Incidence;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidenceFactory extends Factory
{
    protected $model = Incidence::class;

    public function definition(): array
    {
    	return [
            'vehicle_id' => Vehicle::factory()->create()->id,
    	    'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'read' => $this->faker->randomElement([true, false]),
            'resolved' => $this->faker->randomElement([true, false])
    	];
    }
}
