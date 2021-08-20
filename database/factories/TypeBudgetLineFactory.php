<?php

namespace Database\Factories;

use App\Models\TypeBudgetLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeBudgetLineFactory extends Factory
{
    protected $model = TypeBudgetLine::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Recambio', 'Mano de obra', 'Pintura'])
    	];
    }
}
