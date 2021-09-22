<?php

namespace Database\Factories;

use App\Model;
use App\Models\DeliveryVehicle;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryVehicleFactory extends Factory
{
    protected $model = DeliveryVehicle::class;

    public function definition(): array
    {
        $data = [
            'customer' => $this->faker->name,
            'company' => $this->faker->name,
            'check' => $this->faker->randomElement(['ALD Flex', 'Redrive', 'BIPI']),
            'truck' => $this->faker->randomElement(['Volvo', 'MAN', 'RENAULT']),
            'driver' => $this->faker->name,
            'dni' => $this->faker->bothify('########?'),
        ];
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'data_delivery' => json_encode($data),
    	];
    }
}
