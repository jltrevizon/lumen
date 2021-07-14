<?php

use App\Models\Company;
use App\Models\GroupTask;
use App\Models\Incidence;
use App\Models\PendingTask;
use App\Models\PendingTaskCanceled;
use App\Models\StatePendingTask;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingtaskTest extends TestCase
{
    private PendingTask $pendingTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pendingTask = PendingTask::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->pendingTask->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->task());
        $this->assertInstanceOf(Task::class, $this->pendingTask->task()->getModel());
    }

    /** @test */
    public function it_belongs_to_state_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->state_pending_task());
        $this->assertInstanceOf(StatePendingTask::class, $this->pendingTask->state_pending_task()->getModel());
    }

    /** @test */
    public function it_belongs_to_group_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->group_task());
        $this->assertInstanceOf(GroupTask::class, $this->pendingTask->group_task()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_incidences()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->pendingTask->incidences());
        $this->assertInstanceOf(Incidence::class, $this->pendingTask->incidences()->getModel());
    }

    /** @test */
    public function it_has_many_pending_task_canceled()
    {
        $this->assertInstanceOf(HasMany::class, $this->pendingTask->pending_task_canceled());
        $this->assertInstanceOf(PendingTaskCanceled::class, $this->pendingTask->pending_task_canceled()->getModel());
    }
}
