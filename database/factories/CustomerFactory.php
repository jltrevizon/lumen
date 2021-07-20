<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'province_id' => Province::factory()->create()->id,
            'name' => $this->faker->name,
            'cif' => $this->faker->bothify('?########'),
            'phone' => $this->faker->numerify('#########'),
            'address' => $this->faker->address()
    	];
    }
}
