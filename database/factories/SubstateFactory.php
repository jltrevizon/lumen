<?php

namespace Database\Factories;

use App\Model;
use App\Models\State;
use App\Models\SubState;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubstateFactory extends Factory
{
    protected $model = SubState::class;

    public function definition(): array
    {
    	return [
    	    'state_id' => State::factory()->create()->id,
            'name' => $this->faker->name
    	];
    }
}
