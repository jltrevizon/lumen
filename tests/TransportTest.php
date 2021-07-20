<?php

use App\Models\Reservation;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransportTest extends TestCase
{

    use DatabaseTransactions;

    private Transport $transport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transport = Transport::factory()->create();
    }

    /** @test */
    public function it_has_many_reservations()
    {
        $this->assertInstanceOf(HasMany::class, $this->transport->reservations());
        $this->assertInstanceOf(Reservation::class, $this->transport->reservations()->getModel());
    }
}
