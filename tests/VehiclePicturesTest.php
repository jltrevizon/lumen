<?php

use App\Models\Vehicle;
use App\Models\VehiclePicture;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehiclePicturesTest extends TestCase
{

    use DatabaseTransactions;

    private VehiclePicture $vehiclePicture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vehiclePicture = VehiclePicture::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehiclePicture->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->vehiclePicture->vehicle()->getModel());
    }
}
