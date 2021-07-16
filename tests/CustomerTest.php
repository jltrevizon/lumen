<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerTest extends TestCase
{

    use DatabaseTransactions;

    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function it_belongs_to_province()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->customer->province());
        $this->assertInstanceOf(Province::class, $this->customer->province()->getModel());
    }

    /** @test */
    public function it_belongs_to_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->customer->company());
        $this->assertInstanceOf(Company::class, $this->customer->company()->getModel());
    }

    /** @test */
    public function it_has_many_requests()
    {
        $this->assertInstanceOf(HasMany::class, $this->customer->requests());
        $this->assertInstanceOf(Request::class, $this->customer->requests()->getModel());
    }
}
