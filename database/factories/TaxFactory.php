<?php

namespace Database\Factories;

use App\Model;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    protected $model = Tax::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['21%','10%','4%','7%','3%','0%']),
            'value' => $this->faker->randomElement([21, 10, 4, 7, 3, 0]),
            'description' => $this->faker->randomElement(['IVA general','IVA reducido','IVA superreducido','IGIC general','IGIC reducido','IGIC tipo cero'])
    	];
    }
}
