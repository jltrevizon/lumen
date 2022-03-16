<?php

namespace Database\Factories;

use App\Model;
use App\Models\SeverityDamage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeverityDamageFactory extends Factory
{
    protected $model = SeverityDamage::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Leve','Media','Grave'])
    	];
    }
}
