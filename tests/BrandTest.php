<?php

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BrandTest extends TestCase
{

    use DatabaseTransactions;

    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();
        $this->brand = Brand::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicle_model()
    {
        $this->assertInstanceOf(HasMany::class, $this->brand->vehicleModels());
        $this->assertInstanceOf(VehicleModel::class, $this->brand->vehicleModels()->getModel());
    }

    /** @test */
    public function should_return_brand_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->brand->byIds([]));
    }

    /** @test */
    public function should_return_brand_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->brand->byName('name'));
    }
}
