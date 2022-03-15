<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerFilterTest extends TestCase
{
   
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Customer::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $customer = Customer::factory()->create();
        $customers = Customer::filter(['ids' => [$customer->id]])->get();
        $this->assertCount(1, $customers);
    }

    /** @test */
    public function it_can_filter_by_companies()
    {
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        Customer::query()->update(['company_id' => $company1->id]);
        Customer::factory()->create(['company_id' => $company2->id]);
        $customers = Customer::filter(['company_ids' => [$company2->id]])->get();
        $this->assertCount(1, $customers);
    }

    /** @test */
    public function it_can_filter_by_provinces()
    {
        $province1 = Province::factory()->create();
        $province2 = Province::factory()->create();
        Customer::query()->update(['province_id' => $province1->id]);
        Customer::factory()->create(['province_id' => $province2->id]);
        $customers = Customer::filter(['province_ids' => [$province2->id]])->get();
        $this->assertCount(1, $customers);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        Customer::query()->update(['name' => 'Customer 1']);
        $customer = Customer::factory()->create(['name' => 'Customer 2']);
        $customers = Customer::filter(['name' => $customer->name])->get();
        $this->assertCount(1, $customers);
    }

    /** @test */
    public function it_can_filter_by_phone()
    {
        Customer::query()->update(['phone' => 600000000]);
        $customer = Customer::factory()->create(['phone' => 600000001]);
        $customers = Customer::filter(['phone' => $customer->phone])->get();
        $this->assertCount(1, $customers);
    }

    /** @test */
    public function it_can_filter_by_address()
    {
        Customer::query()->update(['address' => 'Address 1']);
        $customer = Customer::factory()->create(['address' => 'Address 2']);
        $customers = Customer::filter(['address' => $customer->address])->get();
        $this->assertCount(1, $customers);
    }
}
