<?php

use App\Models\Company;
use App\Models\ReservationTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReservationTimeTest extends TestCase
{

    use DatabaseTransactions;

    private ReservationTime $reservationTime;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reservationTime = ReservationTime::factory()->create();
    }

    /** @test */
    public function it_belongs_to_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reservationTime->company());
        $this->assertInstanceOf(Company::class, $this->reservationTime->company()->getModel());
    }
}
