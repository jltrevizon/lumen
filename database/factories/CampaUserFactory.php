<?php

namespace Database\Factories;

use App\Model;
use App\Models\Campa;
use App\Models\CampaUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaUserFactory extends Factory
{
    protected $model = CampaUser::class;

    public function definition(): array
    {
    	return [
    	    'campa_id' => Campa::factory()->create()->id,
            'user_id' => User::factory()->create()->id
    	];
    }
}
