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
            'reception_id' => Reception::factory()->count(1)->create()->id,
    	    'name' => $this->faker->name,
            'description' => $this->faker->text
    	];
    }
}
