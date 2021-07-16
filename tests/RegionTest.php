<?php

use App\Models\Province;
use App\Models\Region;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegionTest extends TestCase
{

    use DatabaseTransactions;

    private Region $region;

    protected function setUp(): void
    {
        parent::setUp();
        $this->region = Region::factory()->create();
    }

    /** @test */
    public function it_has_many_provinces()
    {
        $this->assertInstanceOf(HasMany::class, $this->region->provinces());
        $this->assertInstanceOf(Province::class, $this->region->provinces()->getModel());
    }
}
