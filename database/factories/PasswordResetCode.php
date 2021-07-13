<?php

namespace Database\Factories;

use App\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasswordResetCode extends Factory
{
    protected $model = PasswordResetCode::class;

    public function definition(): array
    {
    	return [
    	    'user_id' => User::factory()->create()->id,
            'code' => $this->faker->numerify('######'),
            'active' => $this->faker->randomElement([true, false])
    	];
    }
}
