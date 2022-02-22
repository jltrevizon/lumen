<?php

use App\Models\PendingAuthorization;
use App\Models\StateAuthorization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateAuthorizationTest extends TestCase
{
   
    use DatabaseTransactions;

    private StateAuthorization $stateAuthorization;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stateAuthorization = StateAuthorization::factory()->create();
    }

    /** @test */
    public function it_has_many_pending_authorizations()
    {
        $this->assertInstanceOf(HasMany::class, $this->stateAuthorization->pendingAuthotizations());
        $this->assertInstanceOf(PendingAuthorization::class, $this->stateAuthorization->pendingAuthotizations()->getModel());
    }

}
