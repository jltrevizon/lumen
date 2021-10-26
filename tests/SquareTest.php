<?php

use App\Models\Square;
use App\Models\Street;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SquareTest extends TestCase
{
    
    use DatabaseTransactions;

    private Square $square;

    protected function setUp(): void
    {
        parent::setUp();
        $this->square = Square::factory()->create();
    }

    /** @test */
    public function it_belongs_to_street()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->square->street());
        $this->assertInstanceOf(Street::class, $this->square->street()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->square->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->square->vehicle()->getModel());
    }

    /** @test */
    public function should_return_squares_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->square->byIds([]));
    }

    /** @test */
    public function should_return_squares_by_street_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->square->byStreetIds([]));
    }

    /** @test */
    public function should_return_squares_by_vehicles_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->square->byVehicleIds([]));
    }

    /** @test */
    public function should_return_squares_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->square->byName(''));
    }

}
