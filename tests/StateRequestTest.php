<?php

use App\Models\Request;
use App\Models\Role;
use App\Models\StateRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateRequestTest extends TestCase
{
    use DatabaseTransactions;

    private StateRequest $stateRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stateRequest = StateRequest::factory()->create();
    }

    /** @test */
    public function it_has_many_requests()
    {
        $this->assertInstanceOf(HasMany::class, $this->stateRequest->requests());
        $this->assertInstanceOf(Request::class, $this->stateRequest->requests()->getModel());
    }
}
