<?php

namespace Database\Factories;

use App\Model;
use App\Models\StatusDamage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusDamageFactory extends Factory
{
    protected $model = StatusDamage::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Pendiente','Cerrado','Declinado'])
    	];
    }
}
