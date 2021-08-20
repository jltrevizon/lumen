<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeModelOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeModelOrderFactory extends Factory
{
    protected $model = TypeModelOrder::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name
    	];
    }
}
