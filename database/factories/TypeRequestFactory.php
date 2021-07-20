<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeRequestFactory extends Factory
{
    protected $model = TypeRequest::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Defleet','Reserva'])
    	];
    }
}
