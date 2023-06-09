<?php

namespace Database\Factories;

use App\Model;
use App\Models\Reception;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePicture;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiclePictureFactory extends Factory
{
    protected $model = VehiclePicture::class;

    public function definition(): array
    {
    	return [
            'vehicle_id' => Vehicle::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'reception_id' => Reception::factory()->create()->id,
            'url' => $this->faker->url,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'active' => $this->faker->randomElement([true, false])
    	];
    }
}
