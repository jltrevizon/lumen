<?php

namespace Database\Factories;

use App\Model;
use App\Models\Customer;
use App\Models\Request;
use App\Models\StateRequest;
use App\Models\TypeRequest;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    protected $model = Request::class;

    public function definition(): array
    {
    	return [
            'customer_id' => Customer::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id,
            'state_request_id' => StateRequest::factory()->create()->id,
            'type_request_id' => TypeRequest::factory()->create()->id,
            'datetime_request' => $this->faker->dateTime,
            'datetime_decline' => $this->faker->dateTime,
            'datetime_approved' => $this->faker->dateTime
    	];
    }
}
