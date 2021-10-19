<?php

namespace Database\Factories;

use App\Model;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoginLogFactory extends Factory
{
    protected $model = LoginLog::class;

    public function definition(): array
    {
    	return [
    	    'user_id' => User::factory()->create()->id,
            'device_description' => $this->faker->text
    	];
    }
}
