<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\DefleetVariable;
use Illuminate\Database\Eloquent\Factories\Factory;

class DefleetVariableFactory extends Factory
{
    protected $model = DefleetVariable::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'kms' => $this->faker->numerify('#####'),
            'years' => $this->faker->numerify('#')
    	];
    }
}
