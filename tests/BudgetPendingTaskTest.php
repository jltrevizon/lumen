<?php

use App\Models\BudgetPendingTask;
use App\Models\PendingTask;
use App\Models\Role;
use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetPendingTaskTest extends TestCase
{
    use DatabaseTransactions;

    private BudgetPendingTask $budgetPendingTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->budgetPendingTask = BudgetPendingTask::factory()->create();
    }

    /** @test */
    public function it_belongs_to_role()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetPendingTask->role());
        $this->assertInstanceOf(Role::class, $this->budgetPendingTask->role()->getModel());
    }

    /** @test */
    public function it_belongs_to_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetPendingTask->pendingTask());
        $this->assertInstanceOf(PendingTask::class, $this->budgetPendingTask->pendingTask()->getModel());
    }

    /** @test */
    public function it_belongs_to_state_budget_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetPendingTask->stateBudgetPendingTask());
        $this->assertInstanceOf(StateBudgetPendingTask::class, $this->budgetPendingTask->stateBudgetPendingTask()->getModel());
    }

    /** @test */
    public function should_search_by_pending_task_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetPendingTask->byPendingTaskIds([]));
    }

    /** @test */
    public function should_search_by_state_budget_pending_task_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetPendingTask->byStateBudgetPendingTaskIds([]));
    }

    /** @test */
    public function should_return_budget_pending_task_by_vehicle_plate()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetPendingTask->byPlate(''));
    }
}
