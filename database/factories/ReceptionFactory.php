<?php

namespace Database\Factories;

use App\Model;
use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceptionFactory extends Factory
{
    protected $model = Reception::class;

    public function definition(): array
    {
    	return [
            'vehicle_id' => Vehicle::factory()->create()->id,
            'has_accessories' => $this->faker->boolean(true)
    	];
    }
}
