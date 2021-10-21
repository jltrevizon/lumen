<?php

namespace Database\Factories;

use App\Model;
use App\Models\Comment;
use App\Models\Incidence;
use App\Models\IncidenceImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidenceImageFactory extends Factory
{
    protected $model = IncidenceImage::class;

    public function definition(): array
    {
    	return [
    	    'incidence_id' => Incidence::factory()->create()->id,
            'comment_id' => Comment::factory()->create()->id,
            'url' => $this->faker->url
    	];
    }
}
