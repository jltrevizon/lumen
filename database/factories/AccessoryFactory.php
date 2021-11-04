<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\Reception;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFactory extends Factory
{
    protected $model = Accessory::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
    	];
    }
}
