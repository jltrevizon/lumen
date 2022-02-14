<?php

use App\Models\DeliveryNote;
use App\Models\PendingTask;
use App\Models\Vehicle;
use App\Models\VehicleExist;
use App\Models\VehicleExit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleExitTest extends TestCase
{

    use DatabaseTransactions;

    private VehicleExit $vehicleExit;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vehicleExit = VehicleExit::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicleExit->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->vehicleExit->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicleExit->pendingTask());
        $this->assertInstanceOf(PendingTask::class, $this->vehicleExit->pendingTask()->getModel());
    }

    /** @test */
    public function it_belongs_to_delivery_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicleExit->deliveryNote());
        $this->assertInstanceOf(DeliveryNote::class, $this->vehicleExit->deliveryNote()->getModel());
    }
}
