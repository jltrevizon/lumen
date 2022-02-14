<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeDeliveryNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeDeliveryNoteFactory extends Factory
{
    protected $model = TypeDeliveryNote::class;

    public function definition(): array
    {
    	return [
    	    'description' => $this->faker->randomElement(['Entrega', 'Salida a taller externo'])
    	];
    }
}
