<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\ReservationTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationTimeFactory extends Factory
{
    protected $model = ReservationTime::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'hours' => $this->faker->randomNumber($nbDigits = 2, $strict = false)
    	];
    }
}
