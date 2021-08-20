<?php

namespace Database\Factories;

use App\Model;
use App\Models\Order;
use App\Models\State;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'workshop_id' => Workshop::factory()->create()->id,
            'state_id' => State::factory()->create()->id,
            'type_model_order_id' => TypeModelOrder::factory()->create()->id,
            'id_gsp' => $this->faker->randomNumber(5, 0, 9)
    	];
    }
}
