<?php

use App\Models\State;
use App\Models\SubState;
use App\Models\Vehicle;
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
        $this->assertInstanceOf(HasMany::class, $this->state->sub_states());
        $this->assertInstanceOf(SubState::class, $this->state->sub_states()->getModel());
    }
}
