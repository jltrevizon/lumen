<?php

namespace Database\Factories;

use App\Model;
use App\Models\Campa;
use App\Models\Company;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaFactory extends Factory
{
    protected $model = Campa::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'province_id' => Province::factory()->create()->id,
            'name' => $this->faker->name,
            'location' => $this->faker->state,
            'address' => $this->faker->address,
            'active' => $this->faker->randomElement([true, false])
    	];
    }
}
