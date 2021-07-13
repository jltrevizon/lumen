<?php

namespace Database\Factories;

use App\Model;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
    	];
    }
}
