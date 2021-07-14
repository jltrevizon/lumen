<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeReservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeReservationFactory extends Factory
{
    protected $model = TypeReservation::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Normal','Pre-entrega'])
    	];
    }
}
