<?php

use App\Models\Damage;
use App\Models\PendingAuthorization;
use App\Models\StateAuthorization;
use App\Models\Task;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingAuthorizationTest extends TestCase
{
    
    use DatabaseTransactions;

    private PendingAuthorization $pendingAuthorization;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pendingAuthorization = PendingAuthorization::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingAuthorization->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->pendingAuthorization->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingAuthorization->task());
        $this->assertInstanceOf(Task::class, $this->pendingAuthorization->task()->getModel());
    }

    /** @test */
    public function it_belongs_to_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingAuthorization->damage());
        $this->assertInstanceOf(Damage::class, $this->pendingAuthorization->damage()->getModel());
    }

    /** @test */
    public function it_belongs_to_state_authorization()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingAuthorization->stateAuthorization());
        $this->assertInstanceOf(StateAuthorization::class, $this->pendingAuthorization->stateAuthorization()->getModel());
    }

}
