<?php

namespace Database\Factories;

use App\Model;
use App\Models\GroupTask;
use App\Models\Questionnaire;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupTaskFactory extends Factory
{
    protected $model = GroupTask::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'questionnaire_id' => Questionnaire::factory()->create()->id,
            'approved' => $this->faker->randomElement([true, false]),
            'approved_available' => $this->faker->randomElement([true, false])
    	];
    }
}
