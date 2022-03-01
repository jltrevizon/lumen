<?php

use App\Models\Campa;
use App\Models\DeliveryNote;
use App\Models\DeliveryVehicle;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeliveryVehicleTest extends TestCase
{

    use DatabaseTransactions;

    private DeliveryVehicle $deliveryVehicle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deliveryVehicle = DeliveryVehicle::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->deliveryVehicle->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->deliveryVehicle->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_campa(){
        $this->assertInstanceOf(BelongsTo::class, $this->deliveryVehicle->campa());
        $this->assertInstanceOf(Campa::class, $this->deliveryVehicle->campa()->getModel());
    }

    /** @test */
    public function it_belongs_to_delivery_note(){
        $this->assertInstanceOf(BelongsTo::class, $this->deliveryVehicle->deliveryNote());
        $this->assertInstanceOf(DeliveryNote::class, $this->deliveryVehicle->deliveryNote()->getModel());
    }
}
