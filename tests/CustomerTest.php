<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Request;
use Illuminate\Database\Eloquent\Builder;
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

    /** @test */
    public function should_return_customers_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byIds([]));
    }

    /** @test */
    public function search_by_company()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byCompany(1));
    }

    /** @test */
    public function should_return_customers_by_companies_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byCompanies([]));
    }

    /** @test */
    public function should_return_customers_by_province()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byProvince([]));
    }

    /** @test */
    public function should_return_customers_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byName(''));
    }

    /** @test */
    public function should_return_customers_by_cif()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byCif(''));
    }

    /** @test */
    public function should_return_customers_by_phone()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byPhone(''));
    }

    /** @test */
    public function should_return_customers_by_address()
    {
        $this->assertInstanceOf(Builder::class, $this->customer->byAddress(''));
    }
}
