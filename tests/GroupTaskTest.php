<?php

use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Vehicle;
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
        $this->assertInstanceOf(HasMany::class, $this->groupTask->pending_tasks());
        $this->assertInstanceOf(PendingTask::class, $this->groupTask->pending_tasks()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle(){
        $this->assertInstanceOf(BelongsTo::class, $this->groupTask->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->groupTask->vehicle()->getModel());
    }
}
