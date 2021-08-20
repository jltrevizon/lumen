<?php

namespace Database\Factories;

use App\Model;
use App\Models\PendingDownload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendingDownloadFactory extends Factory
{
    protected $model = PendingDownload::class;

    public function definition(): array
    {
    	return [
    	    'user_id' => User::factory()->create()->id,
            'type_document' => $this->faker->randomElement(['vehicles']),
            'sended' => $this->faker->randomElement([true, false])
    	];
    }
}
