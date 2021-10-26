<?php

namespace Database\Factories;

use App\Model;
use App\Models\Square;
use App\Models\Street;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SquareFactory extends Factory
{
    protected $model = Square::class;

    public function definition(): array
    {
    	return [
    	    'street_id' => Street::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id,
            'name' => $this->faker->name
    	];
    }
}
