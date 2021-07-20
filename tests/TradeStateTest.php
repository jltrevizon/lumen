<?php

use App\Models\TradeState;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TradeStateTest extends TestCase
{

    use DatabaseTransactions;

    private TradeState $tradeState;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tradeState = TradeState::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->tradeState->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->tradeState->vehicles()->getModel());
    }
}
