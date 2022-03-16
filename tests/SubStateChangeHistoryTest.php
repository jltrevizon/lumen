<?php

use App\Models\SubState;
use App\Models\SubStateChangeHistory;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SubStateChangeHistoryTest extends TestCase
{
    
    use DatabaseTransactions;

    private SubStateChangeHistory $subStateChangeHistory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subStateChangeHistory = SubStateChangeHistory::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->subStateChangeHistory->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->subStateChangeHistory->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_sub_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->subStateChangeHistory->subState());
        $this->assertInstanceOf(SubState::class, $this->subStateChangeHistory->subState()->getModel());
    }

}
