<?php

use App\Models\Request;
use App\Models\Reservation;
use App\Models\Transport;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{

    use DatabaseTransactions;

    private Reservation $reservation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reservation = Reservation::factory()->create();
    }

    /** @test */
    public function it_belongs_to_request()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reservation->request());
        $this->assertInstanceOf(Request::class, $this->reservation->request()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reservation->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->reservation->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_transport()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reservation->transport());
        $this->assertInstanceOf(Transport::class, $this->reservation->transport()->getModel());
    }

    /** @test */
    public function should_search_by_company()
    {
        $this->assertInstanceOf(Builder::class, $this->reservation->byCompany(1));
    }
}
