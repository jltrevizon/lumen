<?php

namespace Database\Factories;

use App\Model;
use App\Models\DeliveryNote;
use App\Models\TypeDeliveryNote;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryNoteFactory extends Factory
{
    protected $model = DeliveryNote::class;

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
    	    'type_delivery_note_id' => TypeDeliveryNote::factory()->create()->id,
            'body' => json_encode($data)
    	];
    }
}
