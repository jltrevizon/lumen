<?php

use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleModelTest extends TestCase
{

    use DatabaseTransactions;

    private VehicleModel $vehicleModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vehicleModel = VehicleModel::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicleModel->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->vehicleModel->vehicles()->getModel());
    }

    /** @test */
    public function it_belongs_to_brand()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicleModel->brand());
        $this->assertInstanceOf(Brand::class, $this->vehicleModel->brand()->getModel());
    }
}
