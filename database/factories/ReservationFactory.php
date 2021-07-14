<?php

namespace Database\Factories;

use App\Model;
use App\Models\Campa;
use App\Models\Request;
use App\Models\Reservation;
use App\Models\Transport;
use App\Models\TypeReservation;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
    	return [
    	    'request_id' => Request::factory()->create()->id,
            'vehicle_id' => Vehicle::factory()->create()->id,
            'reservation_time' => $this->faker->randomNumber($nbDigits = 2, $strict = false),
            'dni' => $this->faker->bothify('########?'),
            'order' => $this->faker->url,
            'contract' => $this->faker->url,
            'planned_reservation' => $this->faker->date,
            'pickup_by_customer' => $this->faker->randomElement([true, false]),
            'transport_id' => Transport::factory()->create()->id,
            'actual_date' => $this->faker->date,
            'campa_id' => Campa::factory()->create()->id,
            'type_reservation_id' => TypeReservation::factory()->create()->id,
            'active' => $this->faker->randomElement([true, false])
    	];
    }
}
