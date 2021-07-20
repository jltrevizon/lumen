<?php

namespace Database\Factories;

use App\Model;
use App\Models\StateRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateRequestFactory extends Factory
{
    protected $model = StateRequest::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name
    	];
    }
}
