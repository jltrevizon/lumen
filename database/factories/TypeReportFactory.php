<?php

namespace Database\Factories;

use App\Model;
use App\Models\TypeReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeReportFactory extends Factory
{
    protected $model = TypeReport::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement(['Entradas de vehículos','Salidas de vehículos','Stock de vehículos'])
    	];
    }
}
