<?php

use App\Models\Reception;
use App\Models\User;
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
    public function it_belongs_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehiclePicture->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->vehiclePicture->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehiclePicture->user());
        $this->assertInstanceOf(User::class, $this->vehiclePicture->user()->getModel());
    }

    /** @test */
    public function it_belongs_reception()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehiclePicture->reception());
        $this->assertInstanceOf(Reception::class, $this->vehiclePicture->reception()->getModel());
    }
}
