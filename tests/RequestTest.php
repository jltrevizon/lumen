<?php

use App\Models\Customer;
use App\Models\Request;
use App\Models\Reservation;
use App\Models\StateRequest;
use App\Models\TypeRequest;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RequestTest extends TestCase
{
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = Request::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->request->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->request->vehicle()->getModel());
    }

     /** @test */
     public function it_belongs_to_state_request()
     {
         $this->assertInstanceOf(BelongsTo::class, $this->request->state_request());
         $this->assertInstanceOf(StateRequest::class, $this->request->state_request()->getModel());
     }

      /** @test */
    public function it_belongs_to_type_request()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->request->type_request());
        $this->assertInstanceOf(TypeRequest::class, $this->request->type_request()->getModel());
    }

     /** @test */
     public function it_has_one_reservation()
     {
         $this->assertInstanceOf(HasOne::class, $this->request->reservation());
         $this->assertInstanceOf(Reservation::class, $this->request->reservation()->getModel());
     }

      /** @test */
    public function it_belongs_to_customer()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->request->customer());
        $this->assertInstanceOf(Customer::class, $this->request->customer()->getModel());
    }
}
