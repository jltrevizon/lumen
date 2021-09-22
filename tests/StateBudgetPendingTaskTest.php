<?php

use App\Models\BudgetPendingTask;
use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateBudgetPendingTaskTest extends TestCase
{

    use DatabaseTransactions;

    private StateBudgetPendingTask $stateBudgetPendingTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stateBudgetPendingTask = StateBudgetPendingTask::factory()->create();
    }

    /** @test */
    public function it_has_many_budget_pending_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->stateBudgetPendingTask->budgetPendingTasks());
        $this->assertInstanceOf(BudgetPendingTask::class, $this->stateBudgetPendingTask->budgetPendingTasks()->getModel());
    }

}
