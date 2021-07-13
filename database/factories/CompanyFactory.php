<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
            'tradename' => $this->faker->company,
            'nif' => $this->faker->uuid,
            'address' => $this->faker->address,
            'location' => $this->faker->state,
            'phone' => $this->faker->numerify('#########'),
            'logo' => $this->faker->imageUrl
    	];
    }
}
