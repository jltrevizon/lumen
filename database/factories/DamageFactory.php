<?php

namespace Database\Factories;

use App\Model;
use App\Models\Damage;
use App\Models\StatusDamage;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageFactory extends Factory
{
    protected $model = Damage::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'task_id' => Task::factory()->create()->id,
            'status_damage_id' => StatusDamage::factory()->create()->id,
            'description' => $this->faker->text
    	];
    }
}
