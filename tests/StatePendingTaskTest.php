<?php

use App\Models\PendingTask;
use App\Models\StatePendingTask;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StatePendingTaskTest extends TestCase
{

    use DatabaseTransactions;

    private StatePendingTask $statePendingTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->statePendingTask = StatePendingTask::factory()->create();
    }

    /** @test */
    public function it_has_many_pending_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->statePendingTask->pending_tasks());
        $this->assertInstanceOf(PendingTask::class, $this->statePendingTask->pending_tasks()->getModel());
    }
}
