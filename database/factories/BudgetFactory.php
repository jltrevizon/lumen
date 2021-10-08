<?php

namespace Database\Factories;

use App\Model;
use App\Models\Budget;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'order_id' => Order::factory()->create()->id,
            'sub_total' => $this->faker->randomFloat(2, 0, 1000),
            'tax' => $this->faker->randomFloat(2, 0, 1000),
            'total' => $this->faker->randomFloat(2, 0, 2000)
    	];
    }
}
