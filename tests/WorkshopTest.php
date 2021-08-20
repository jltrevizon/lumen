<?php

use App\Models\Order;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WorkshopTest extends TestCase
{

    use DatabaseTransactions;

    private Workshop $workshop;

    protected function setUp(): void
    {
        parent::setUp();
        $this->workshop = Workshop::factory()->create();
    }

    /** @test */
    public function it_has_many_orders()
    {
        $this->assertInstanceOf(HasMany::class, $this->workshop->orders());
        $this->assertInstanceOf(Order::class, $this->workshop->orders()->getModel());
    }
}
