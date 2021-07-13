<?php

namespace Database\Factories;

use App\Model;
use App\Models\Campa;
use App\Models\Category;
use App\Models\SubState;
use App\Models\TradeState;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
    	return [
    	    'remote_id' => $this->faker->numerify('##########'),
            'campa_id' => Campa::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'sub_state_id' => SubState::factory()->create()->id,
            'ubication' => $this->faker->name,
            'plate' => $this->faker->bothify('####???'),
            'vehicle_model_id' => VehicleModel::factory()->create()->id,
            'kms' => $this->faker->numerify('######'),
            'priority' => $this->faker->randomElement([true, false]),
            'version' => $this->faker->name,
            'vin' => $this->faker->address,
            'first_plate' => $this->faker->date,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image' => $this->faker->imageUrl,
            'trade_state_id' => TradeState::factory()->create()->id
    	];
    }
}
