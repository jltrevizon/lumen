<?php

use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ZoneTest extends TestCase
{

    use DatabaseTransactions;

    private Zone $zone;

    protected function setUp(): void
    {
        parent::setUp();
        $this->zone = Zone::factory()->create();
    }

    /** @test */
    public function should_return_zones_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->zone->byIds([]));
    }


    /** @test */
    public function should_return_zones_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->zone->byName(''));
    }

}
