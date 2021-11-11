<?php

use App\Models\HistoryLocation;
use App\Models\Square;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HistoryLocationTest extends TestCase
{
    
    use DatabaseTransactions;

    private HistoryLocation $historyLocation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->historyLocation = HistoryLocation::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->historyLocation->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->historyLocation->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_square()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->historyLocation->square());
        $this->assertInstanceOf(Square::class, $this->historyLocation->square()->getModel());
    }

}
