<?php

namespace Database\Factories;

use App\Model;
use App\Models\Accessory;
use App\Models\AccessoryVehicle;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryVehicleFactory extends Factory
{
    protected $model = AccessoryVehicle::class;

    public function definition(): array
    {
    	return [
    	    'accessory_id' => Accessory::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id
    	];
    }
}
