<?php

use App\Models\Accessory;
use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryTest extends TestCase
{
    use DatabaseTransactions;

    private Accessory $accessory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessory = Accessory::factory()->create();
    }

    /** @test */
    public function it_belongs_to_reception()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->accessory->reception());
        $this->assertInstanceOf(Reception::class, $this->accessory->reception()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->accessory->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->accessory->vehicle()->getModel());
    }
}
