<?php

namespace Database\Factories;

use App\Model;
use App\Models\TradeState;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradeStateFactory extends Factory
{
    protected $model = TradeState::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name
    	];
    }
}
