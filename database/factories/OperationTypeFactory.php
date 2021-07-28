<?php

namespace Database\Factories;

use App\Model;
use App\Models\OperationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationTypeFactory extends Factory
{
    protected $model = OperationType::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Repara', 'Sustituir'])
    	];
    }
}
