<?php

use App\Models\Street;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StreetTest extends TestCase
{
   
    use DatabaseTransactions;

    private Street $street;

    protected function setUp(): void
    {
        parent::setUp();
        $this->street = Street::factory()->create();
    }

    /** @test */
    public function it_belongs_to_zone()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->street->zone());
        $this->assertInstanceOf(Zone::class, $this->street->zone()->getModel());
    }

    /** @test */
    public function should_return_streets_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->street->byIds([]));
    }

    /** @test */
    public function should_return_streets_by_zone_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->street->byZoneIds([]));
    }

    /** @test */
    public function should_return_streets_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->street->byName(''));
    }

}
