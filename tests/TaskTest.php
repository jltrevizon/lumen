<?php

use App\Models\Damage;
use App\Models\PendingAuthorization;
use App\Models\PendingTask;
use App\Models\PurchaseOperation;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    /** @test */
    public function it_has_many_pending_authorizations()
    {
        $this->assertInstanceOf(HasMany::class, $this->task->pendingAuthorizations());
        $this->assertInstanceOf(PendingAuthorization::class, $this->task->pendingAuthorizations()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_damages()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->task->damages());
        $this->assertInstanceOf(Damage::class, $this->task->damages()->getModel());
    }

    /** @test */
    public function should_search_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->task->byIds([]));
    }

    /** @test */
    public function should_search_by_type_task()
    {
        $this->assertInstanceOf(Builder::class, $this->task->byTypeTasks([]));
    }

    /** @test */
    public function should_search_by_sub_states()
    {
        $this->assertInstanceOf(Builder::class, $this->task->bySubStates([]));
    }

    /** @test */
    public function should_search_by_company()
    {
        $this->assertInstanceOf(Builder::class, $this->task->byCompany([]));
    }
}
