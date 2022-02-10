<?php

use App\Models\Accessory;
use App\Models\Campa;
use App\Models\GroupTask;
use App\Models\Reception;
use App\Models\Vehicle;
use App\Models\VehiclePicture;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReceptionTest extends TestCase
{

    use DatabaseTransactions;

    private Reception $reception;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reception = Reception::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reception->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->reception->vehicle()->getModel());
    }

    /** @test */
    public function it_has_many_accessories()
    {
        $this->assertInstanceOf(HasMany::class, $this->reception->accessories());
        $this->assertInstanceOf(Accessory::class, $this->reception->accessories()->getModel());
    }

     /** @test */
     public function it_has_many_vehicle_pictures()
     {
         $this->assertInstanceOf(HasMany::class, $this->reception->vehiclePictures());
         $this->assertInstanceOf(VehiclePicture::class, $this->reception->vehiclePictures()->getModel());
     }

    /** @test */
    public function it_belongs_to_campa()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reception->campa());
        $this->assertInstanceOf(Campa::class, $this->reception->campa()->getModel());
    }

    /** @test */
    public function it_belongs_to_group_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->reception->groupTask());
        $this->assertInstanceOf(GroupTask::class, $this->reception->groupTask()->getModel());
    }
}
