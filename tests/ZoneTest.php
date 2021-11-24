<?php

use App\Models\Campa;
use App\Models\Street;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function it_belongs_to_campa()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->zone->campa());
        $this->assertInstanceOf(Campa::class, $this->zone->campa()->getModel());
    }

    /** @test */
    public function it_has_many_streets()
    {
        $this->assertInstanceOf(HasMany::class, $this->zone->streets());
        $this->assertInstanceOf(Street::class, $this->zone->streets()->getModel());
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

    /** @test */
    public function should_return_zones_by_campa_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->zone->byCampaIds([]));
    }

}
