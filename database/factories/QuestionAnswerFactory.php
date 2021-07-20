<?php

namespace Database\Factories;

use App\Model;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionAnswerFactory extends Factory
{
    protected $model = QuestionAnswer::class;

    public function definition(): array
    {
    	return [
    	    'questionnaire_id' => Questionnaire::factory()->create()->id,
            'question_id' => Question::factory()->create()->id,
            'response' => $this->faker->randomElement([true, false]),
            'description' => $this->faker->text
    	];
    }
}
