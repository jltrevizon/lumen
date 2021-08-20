<?php

namespace Database\Factories;

use App\Model;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkshopFactory extends Factory
{
    protected $model = Workshop::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
            'cif' => $this->faker->bothify('B########'),
            'address' => $this->faker->address,
            'location' => $this->faker->city,
            'province' => $this->faker->city,
            'phone' => $this->faker->randomNumber(9,0,9)
    	];
    }
}
