<?php

namespace Database\Factories;

use App\Model;
use App\Models\Comment;
use App\Models\Incidence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
    	return [
    	    'incidence_id' => Incidence::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'description' => $this->faker->text
    	];
    }
}
