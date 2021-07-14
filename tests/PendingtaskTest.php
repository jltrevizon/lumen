<?php

use App\Models\Company;
use App\Models\PendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
