<?php

use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GroupTaskTest extends TestCase
{

    use DatabaseTransactions;

    private GroupTask $groupTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupTask = GroupTask::factory()->create();
    }

    /** @test */
    public function it_has_many_pending_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->groupTask->pendingTasks());
        $this->assertInstanceOf(PendingTask::class, $this->groupTask->pendingTasks()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle(){
        $this->assertInstanceOf(BelongsTo::class, $this->groupTask->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->groupTask->vehicle()->getModel());
    }

    /** @test */
    public function should_return_group_tasks_by_ids(){
        $this->assertInstanceOf(Builder::class, $this->groupTask->byIds([]));
    }

    /** @test */
    public function should_return_group_tasks_by_vehicles_ids(){
        $this->assertInstanceOf(Builder::class, $this->groupTask->byVehicleIds([]));
    }

    /** @test */
    public function should_return_group_tasks_approved(){
        $this->assertInstanceOf(Builder::class, $this->groupTask->byApproved(1));
    }
}
