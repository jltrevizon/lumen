<?php

namespace Database\Factories;

use App\Model;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\PendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationFactory extends Factory
{
    protected $model = Operation::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'pending_task_id' => PendingTask::factory()->create()->id,
            'operation_type_id' => OperationType::factory()->create()->id,
            'description' => $this->faker->text
    	];
    }
}
