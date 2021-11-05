<?php

namespace Database\Factories;

use App\Model;
use App\Models\DamageImage;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageImageFactory extends Factory
{
    protected $model = DamageImage::class;

    public function definition(): array
    {
    	return [
    	    'user_id' => User::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id,
            'description' => $this->faker->name
    	];
    }
}
