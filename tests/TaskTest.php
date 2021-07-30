<?php

use App\Models\PendingTask;
use App\Models\PurchaseOperation;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{

    use DatabaseTransactions;

    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->task = Task::factory()->create();
    }

    /** @test */
    public function it_has_many_pending_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->task->pendingTasks());
        $this->assertInstanceOf(PendingTask::class, $this->task->pendingTasks()->getModel());
    }

    /** @test */
    public function it_belongs_to_sub_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->task->subState());
        $this->assertInstanceOf(SubState::class, $this->task->subState()->getModel());
    }

    /** @test */
    public function it_belongs_to_type_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->task->typeTask());
        $this->assertInstanceOf(TypeTask::class, $this->task->typeTask()->getModel());
    }

    /** @test */
    public function it_has_many_purchase_operations()
    {
        $this->assertInstanceOf(HasMany::class, $this->task->purchaseOperations());
        $this->assertInstanceOf(PurchaseOperation::class, $this->task->purchaseOperations()->getModel());
    }
}
