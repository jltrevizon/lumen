<?php

namespace Database\Factories;

use App\Model;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    public function definition(): array
    {
    	return [
    	    'region_id' => Region::factory()->create()->id,
            'province_code' => $this->faker->uuid,
            'name' => $this->faker->name
    	];
    }
}
