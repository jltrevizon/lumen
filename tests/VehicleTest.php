<?php

use App\Models\Campa;
use App\Models\Category;
use App\Models\GroupTask;
use App\Models\Operation;
use App\Models\PendingTask;
use App\Models\Questionnaire;
use App\Models\Request;
use App\Models\Reservation;
use App\Models\SubState;
use App\Models\TradeState;
use App\Models\Vehicle;
use App\Models\VehicleExit;
use App\Models\VehicleModel;
use App\Models\VehiclePicture;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleTest extends TestCase
{

    use DatabaseTransactions;

    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vehicle = Vehicle::factory()->create();
    }

    /** @test */
    public function it_belongs_to_category()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicle->category());
        $this->assertInstanceOf(Category::class, $this->vehicle->category()->getModel());
    }

    /** @test */
    public function it_belongs_to_campa()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicle->campa());
        $this->assertInstanceOf(Campa::class, $this->vehicle->campa()->getModel());
    }

    /** @test */
    public function it_belongs_to_sub_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicle->subState());
        $this->assertInstanceOf(SubState::class, $this->vehicle->subState()->getModel());
    }

    /** @test */
    public function it_has_many_requests()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->requests());
        $this->assertInstanceOf(Request::class, $this->vehicle->requests()->getModel());
    }

    /** @test */
    public function it_has_many_pending_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->pendingTasks());
        $this->assertInstanceOf(PendingTask::class, $this->vehicle->pendingTasks()->getModel());
    }

     /** @test */
     public function it_has_many_group_task()
     {
         $this->assertInstanceOf(HasMany::class, $this->vehicle->groupTasks());
         $this->assertInstanceOf(GroupTask::class, $this->vehicle->groupTasks()->getModel());
     }

      /** @test */
    public function it_has_many_vehicle_pictures()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->vehiclePictures());
        $this->assertInstanceOf(VehiclePicture::class, $this->vehicle->vehiclePictures()->getModel());
    }

     /** @test */
     public function it_has_many_reservations()
     {
         $this->assertInstanceOf(HasMany::class, $this->vehicle->reservations());
         $this->assertInstanceOf(Reservation::class, $this->vehicle->reservations()->getModel());
     }

      /** @test */
    public function it_belongs_to_trade_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicle->tradeState());
        $this->assertInstanceOf(TradeState::class, $this->vehicle->tradeState()->getModel());
    }

    /** @test */
    public function it_has_many_questionnaire()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->questionnaires());
        $this->assertInstanceOf(Questionnaire::class, $this->vehicle->questionnaires()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle_model()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->vehicle->vehicleModel());
        $this->assertInstanceOf(VehicleModel::class, $this->vehicle->vehicleModel()->getModel());
    }

    /** @test */
    public function it_has_many_vehicle_exit()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->vehicleExits());
        $this->assertInstanceOf(VehicleExit::class, $this->vehicle->vehicleExits()->getModel());
    }

    /** @test */
    public function it_has_many_operations()
    {
        $this->assertInstanceOf(HasMany::class, $this->vehicle->operations());
        $this->assertInstanceOf(Operation::class, $this->vehicle->operations()->getModel());
    }
}
