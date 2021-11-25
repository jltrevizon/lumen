<?php

namespace Database\Factories;

use App\Model;
use App\Models\Comment;
use App\Models\Damage;
use App\Models\Incidence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
    	return [
    	    'damage_id' => Damage::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'description' => $this->faker->text
    	];
    }
}
