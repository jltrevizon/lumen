<?php

namespace Database\Factories;

use App\Model;
use App\Models\Street;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    protected $model = Street::class;

    public function definition(): array
    {
    	return [
    	    'zone_id' => Zone::factory()->create()->id,
            'name' => $this->faker->name
    	];
    }
}
