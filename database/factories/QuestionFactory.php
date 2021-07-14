<?php

namespace Database\Factories;

use App\Model;
use App\Models\Company;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
    	return [
    	    'company_id' => Company::factory()->create()->id,
            'question' => $this->faker->text,
            'description' => $this->faker->text
    	];
    }
}
