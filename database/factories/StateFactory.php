<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
    	return [
            'company_id' => Company::factory()->create()->id,
            'name' => $this->faker->name
    	];
    }
}
