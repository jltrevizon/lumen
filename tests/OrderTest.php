<?php

use App\Models\Order;
use App\Models\State;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{

    use DatabaseTransactions;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        $this->order = Order::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->order->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_workshop()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->workshop());
        $this->assertInstanceOf(Workshop::class, $this->order->workshop()->getModel());
    }

    /** @test */
    public function it_belongs_to_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->state());
        $this->assertInstanceOf(State::class, $this->order->state()->getModel());
    }

    /** @test */
    public function it_belongs_to_type_model_order()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->typeModelOrder());
        $this->assertInstanceOf(TypeModelOrder::class, $this->order->typeModelOrder()->getModel());
    }

    /** @test */
    public function search_by_states_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->order->byStateIds([]));
    }

    /** @test */
    public function search_by_workshop_id()
    {
        $this->assertInstanceOf(Builder::class, $this->order->byWorkshopId(1));
    }

    /** @test */
    public function should_return_order_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->order->byIds([]));
    }

    /** @test */
    public function should_return_orders_by_vehicle_plate()
    {
        $this->assertInstanceOf(Builder::class, $this->order->byVehiclePlate(''));
    }
}
