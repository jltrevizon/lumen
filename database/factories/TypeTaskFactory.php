<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeTaskFactory extends Factory
{
    protected $model = TypeTask::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name
    	];
    }
}
