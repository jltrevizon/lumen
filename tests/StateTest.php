<?php

use App\Models\Order;
use App\Models\State;
use App\Models\SubState;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateTest extends TestCase
{

    use DatabaseTransactions;

    private State $state;

    protected function setUp(): void
    {
        parent::setUp();
        $this->state = State::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->state->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->state->vehicles()->getModel());
    }

    /** @test */
    public function it_has_many_sub_states()
    {
        $this->assertInstanceOf(HasMany::class, $this->state->subStates());
        $this->assertInstanceOf(SubState::class, $this->state->subStates()->getModel());
    }

    /** @test */
    public function it_has_many_orders()
    {
        $this->assertInstanceOf(HasMany::class, $this->state->orders());
        $this->assertInstanceOf(Order::class, $this->state->orders()->getModel());
    }

    /** @test */
    public function should_return_by_company_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->state->byCompany([]));
    }

    /** @test */
    public function should_return_by_type_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->state->byType([]));
    }
}
