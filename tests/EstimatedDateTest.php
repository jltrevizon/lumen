<?php

use App\Models\EstimatedDate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class EstimatedDateTest extends TestCase
{

    use DatabaseTransactions;

    private EstimatedDate $estimatedDate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->estimatedDate = EstimatedDate::factory()->create();
    }

    /** @test */
    public function it_belongs_to_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->estimatedDate->pendingTask());
    }
}
