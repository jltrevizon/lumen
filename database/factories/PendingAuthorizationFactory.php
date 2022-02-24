<?php

namespace Database\Factories;

use App\Model;
use App\Models\Damage;
use App\Models\Incidence;
use App\Models\PendingAuthorization;
use App\Models\StateAuthorization;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendingAuthorizationFactory extends Factory
{
    protected $model = PendingAuthorization::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'task_id' => Task::factory()->create()->id,
            'damage_id' => Damage::factory()->create()->id,
            'state_authorization_id' => StateAuthorization::factory()->create()->id
    	];
    }
}
