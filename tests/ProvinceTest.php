<?php

use App\Models\Campa;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProvinceTest extends TestCase
{

    use DatabaseTransactions;

    private Province $province;

    protected function setUp(): void
    {
        parent::setUp();
        $this->province = Province::factory()->create();
    }

    /** @test */
    public function it_belongs_to_region()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->province->region());
        $this->assertInstanceOf(Region::class, $this->province->region()->getModel());
    }

    /** @test */
    public function it_has_many_campas()
    {
        $this->assertInstanceOf(HasMany::class, $this->province->campas());
        $this->assertInstanceOf(Campa::class, $this->province->campas()->getModel());
    }

    /** @test */
    public function it_has_many_customers()
    {
        $this->assertInstanceOf(HasMany::class, $this->province->customers());
        $this->assertInstanceOf(Customer::class, $this->province->customers()->getModel());
    }

    /** @test */
    public function should_return_provinces_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->province->byIds([]));
    }

    /** @test */
    public function should_return_provinces_by_region_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->province->byRegionIds([]));
    }

    /** @test */
    public function should_return_provinces_by_province_code()
    {
        $this->assertInstanceOf(Builder::class, $this->province->byProvinceCode(''));
    }

    /** @test */
    public function should_return_provinces_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->province->byName(''));
    }
}
