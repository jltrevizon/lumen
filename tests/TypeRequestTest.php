<?php

use App\Models\Request;
use App\Models\TypeRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeRequestTest extends TestCase
{

    use DatabaseTransactions;

    private TypeRequest $typeRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeRequest = TypeRequest::factory()->create();
    }

    /** @test */
    public function it_has_many_requests()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeRequest->requests());
        $this->assertInstanceOf(Request::class, $this->typeRequest->requests()->getModel());
    }

}
