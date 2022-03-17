<?php

namespace Database\Factories;

use App\Model;
use App\Models\AccessoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryTypeFactory extends Factory
{
    protected $model = AccessoryType::class;

    public function definition(): array
    {
    	return [
            'description' => $this->faker->randomElement(['Accesorios','Documentación'])
    	];
    }
}
