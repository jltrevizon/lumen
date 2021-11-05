<?php

namespace Database\Factories;

use App\Model;
use App\Models\Damage;
use App\Models\DamageImage;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageImageFactory extends Factory
{
    protected $model = DamageImage::class;

    public function definition(): array
    {
    	return [
    	    'damage_id' => Damage::factory()->create()->id,
            'url' => $this->faker->imageUrl
    	];
    }
}
