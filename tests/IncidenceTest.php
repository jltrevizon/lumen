<?php

use App\Models\Incidence;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncidenceTest extends TestCase
{

    use DatabaseTransactions;

    private Incidence $incidence;

    protected function setUp(): void
    {
        parent::setUp();
        $this->incidence = Incidence::factory()->create();
    }

    /** @test */
    public function it_belongs_to_many_pending_tasks()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->incidence->pending_tasks());
        $this->assertInstanceOf(PendingTask::class, $this->incidence->pending_tasks()->getModel());
    }
}
