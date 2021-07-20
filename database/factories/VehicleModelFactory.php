<?php

namespace Database\Factories;

use App\Model;
use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelFactory extends Factory
{
    protected $model = VehicleModel::class;

    public function definition(): array
    {
    	return [
    	    'brand_id' => Brand::factory()->create()->id,
            'name' => $this->faker->name
    	];
    }
}
