<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\ReservationTime as ModelsReservationTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationTime extends Factory
{
    protected $model = ModelsReservationTime::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'hours' => $this->faker->randomDigitNotZero
    	];
    }
}
