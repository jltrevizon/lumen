<?php

use App\Models\Company;
use App\Models\GroupTask;
use App\Models\Incidence;
use App\Models\Operation;
use App\Models\PendingTask;
use App\Models\PendingTaskCanceled;
use App\Models\StatePendingTask;
use App\Models\Task;
use App\Models\Vehicle;
use App\Models\VehicleExit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingtaskTest extends TestCase
{

    use DatabaseTransactions;

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
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->statePendingTask());
        $this->assertInstanceOf(StatePendingTask::class, $this->pendingTask->statePendingTask()->getModel());
    }

    /** @test */
    public function it_belongs_to_group_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingTask->groupTask());
        $this->assertInstanceOf(GroupTask::class, $this->pendingTask->groupTask()->getModel());
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
        $this->assertInstanceOf(HasMany::class, $this->pendingTask->pendingTaskCanceled());
        $this->assertInstanceOf(PendingTaskCanceled::class, $this->pendingTask->pendingTaskCanceled()->getModel());
    }

    /** @test */
    public function it_has_one_vehicle_exit()
    {
        $this->assertInstanceOf(HasOne::class, $this->pendingTask->vehicleExit());
        $this->assertInstanceOf(VehicleExit::class, $this->pendingTask->vehicleExit()->getModel());
    }

    /** @test */
    public function it_has_many_operations()
    {
        $this->assertInstanceOf(HasMany::class, $this->pendingTask->operations());
        $this->assertInstanceOf(Operation::class, $this->pendingTask->operations()->getModel());
    }

    /** @test */
    public function should_search_by_campas()
    {
        $this->assertInstanceOf(Builder::class, $this->pendingTask->byCampas([]));
    }

    /** @test */
    public function should_search_by_pending_or_in_progress()
    {
        $this->assertInstanceOf(Builder::class, $this->pendingTask->pendingOrInProgress());
    }

    /** @test */
    public function should_can_see_homework()
    {
        $this->assertInstanceOf(Builder::class, $this->pendingTask->canSeeHomework(1));
    }

    /** @test */
    public function should_search_by_plate()
    {
        $this->assertInstanceOf(Builder::class, $this->pendingTask->byPlate('0000AAA'));
    }
}
