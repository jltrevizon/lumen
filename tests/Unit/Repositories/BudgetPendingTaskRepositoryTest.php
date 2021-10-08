<?php

use App\Models\BudgetPendingTask;
use App\Models\PendingTask;
use App\Models\StateBudgetPendingTask;
use App\Repositories\BudgetPendingTaskRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetPendingTaskRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new BudgetPendingTaskRepository();
    }

    /** @test */
    public function should_create_a_budget_pending_task_correctly()
    {
        $pendingTaskId = PendingTask::factory()->create()->id;
        $stateBudgetPendingTaskId = StateBudgetPendingTask::factory()->create()->id;
        $request = new Request();
        $request->replace([
            'pending_task_id' => $pendingTaskId,
            'state_budget_pending_task_id' => $stateBudgetPendingTaskId,
            'url' => 'http://localhost.com'
        ]);

        $result = $this->repository->create($request);
        $this->assertEquals($pendingTaskId, $result['pending_task_id']);
        $this->assertEquals($stateBudgetPendingTaskId, $result['state_budget_pending_task_id']);
    }

    /** @test */
    public function should_update_a_budget_pending_task_correctly()
    {
        $budgetPendingTask = BudgetPendingTask::factory()->create();
        $url = 'http://localhost';
        $request = new Request();
        $request->replace([
            'url' => $url
        ]);
        $result = $this->repository->update($request, $budgetPendingTask->id);
        $this->assertEquals($url, $result['budget_pending_task']['url']);
        $this->assertEquals($budgetPendingTask->id, $result['budget_pending_task']['id']);
    }

    /** @test */
    public function should_return_two_budgets_pending_task()
    {
        BudgetPendingTask::factory()->create();
        BudgetPendingTask::factory()->create();
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result->items());
    }

}
