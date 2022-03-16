<?php

use App\Filters\BudgetPendingTaskFilter;
use App\Models\BudgetLine;
use App\Models\BudgetPendingTask;
use App\Models\PendingTask;
use App\Models\StateBudgetPendingTask;
use App\Models\Vehicle;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetPendingTaskFilterTest extends TestCase
{
 
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        BudgetPendingTask::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_pending_task_ids()
    {
        $pendingTask1 = PendingTask::factory()->create();
        $pendingTask2 = PendingTask::factory()->create();
        BudgetPendingTask::query()->update(['pending_task_id' => $pendingTask1->id]);
        $budgetLine = BudgetPendingTask::factory()->create(['pending_task_id' => $pendingTask2->id]);
        $budgetPendingTasks = BudgetPendingTask::filter(['pending_tasks' => [$pendingTask2->id]])->get();
        $this->assertCount(1, $budgetPendingTasks);
        $this->assertEquals($budgetPendingTasks[0]->id, $budgetLine->id);
    }

    /** @test */
    public function it_can_filter_by_state_budget_pending_tasks()
    {
        $state1 = StateBudgetPendingTask::factory()->create();
        $state2 = StateBudgetPendingTask::factory()->create();
        BudgetPendingTask::query()->update(['state_budget_pending_task_id' => $state1->id]);
        $budgetLine = BudgetPendingTask::factory()->create(['state_budget_pending_task_id' => $state2->id]);
        $budgetPendingTasks = BudgetPendingTask::filter(['state_budget_pending_tasks' => [$budgetLine->state_budget_pending_task_id]])->get();
        $this->assertCount(1, $budgetPendingTasks);
        $this->assertEquals($budgetPendingTasks[0]->id, $budgetLine->id);
    }

    /** @test */
    public function it_can_filter_by_vehicle_plate()
    {
        $vehicle = Vehicle::factory()->create();
        $budgetPendingTask = BudgetPendingTask::factory()->create();
        $pendingTask = PendingTask::findOrFail($budgetPendingTask->pending_task_id);
        $pendingTask->vehicle_id = $vehicle->id;
        $pendingTask->save();
        $budgetPendingTasks = BudgetPendingTask::filter(['vehicle_plate' => $vehicle->plate])->get();
        $this->assertCount(1, $budgetPendingTasks);
    }

    /** @test */
    public function it_can_filter_by_created_at()
    {
        BudgetPendingTask::query()->update(['created_at' => Carbon::today()->subDay()]);
        BudgetPendingTask::factory()->create();
        $budgetPendingTasks = BudgetPendingTask::filter(['created_at' => date('Y-m-d')])->get();
        $this->assertCount(1, $budgetPendingTasks);
    }

    /** @test */
    public function it_can_filter_by_created_at_from()
    {
        BudgetPendingTask::query()->update(['created_at' => Carbon::today()->subDay()]);
        BudgetPendingTask::factory()->create();
        $budgetPendingTasks = BudgetPendingTask::filter(['created_at' => date('Y-m-d')])->get();
        $this->assertCount(1, $budgetPendingTasks);
    }
    
    /** @test */
    public function it_can_filter_by_created_at_to()
    {
        BudgetPendingTask::query()->update(['created_at' => Carbon::today()->subDay()]);
        BudgetPendingTask::factory()->create();
        $budgetPendingTasks = BudgetPendingTask::filter(['created_at' => date('Y-m-d')])->get();
        $this->assertCount(1, $budgetPendingTasks);
    }
    

}
