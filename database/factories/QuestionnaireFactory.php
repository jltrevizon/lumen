<?php

namespace Database\Factories;

use App\Model;
use App\Models\Questionnaire;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionnaireFactory extends Factory
{
    protected $model = Questionnaire::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id
    	];
    }
}
