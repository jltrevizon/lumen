<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeUserApp;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeUserAppFactory extends Factory
{
    protected $model = TypeUserApp::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name(),
            'description' => $this->faker->name()
    	];
    }
}
