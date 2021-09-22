<?php

namespace Database\Factories;

use App\Model;
use App\Models\BudgetPendingTask;
use App\Models\PendingTask;
use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetPendingTaskFactory extends Factory
{
    protected $model = BudgetPendingTask::class;

    public function definition(): array
    {
    	return [
    	    'pending_task_id' => PendingTask::factory()->create()->id,
            'state_budget_pending_task_id' => StateBudgetPendingTask::factory()->create()->id,
            'url' => $this->faker->url
    	];
    }
}
