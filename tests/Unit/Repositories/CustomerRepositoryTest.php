<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CustomerRepository();
    }

    /** @test */
    public function it_can_a_create_customer_correctly()
    {
        $company = Company::factory()->create();
        $province = Province::factory()->create();
        $data = [
            'company_id' => $company->id,
            'province_id' => $province->id,
            'name' => 'Test Customer',
            'cif' => 'B00000000',
            'phone' => '650000000',
            'address' => 'Test address'
        ];
        $request = new Request();
        $request->replace($data);
        $result = $this->createCustomer($request);
        $this->assertEquals($data['name'], $result['name']);
        $this->assertEquals($data['cif'], $result['cif']);
        $this->assertEquals($data['phone'], $result['phone']);
        $this->assertEquals($data['address'], $result['address']);
    }

    /** @test */
    public function should_return_two_customers()
    {
        Customer::factory()->create();
        Customer::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(Customer::count(), $result->items());
    }

    /** @test */
    public function should_return_zero_customers()
    {
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(0, []);
    }

    /** @test */
    public function should_return_a_customer_by_id()
    {
        $customer = Customer::factory()->create();
        $result = $this->repository->getById($customer['id']);
        $this->assertEquals($customer['id'], $result['id']);
        $this->assertEquals($customer['name'], $result['name']);
        $this->assertEquals($customer['cif'], $result['cif']);
        $this->assertEquals($customer['phone'], $result['phone']);
        $this->assertEquals($customer['address'], $result['address']);
    }

    /** @test */
    public function should_updated_a_customer_correctly()
    {
        $name = 'Test Updated Customer';
        $customer = Customer::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $customer['id']);
        $this->assertEquals($name, $result['customer']['name']);
    }

    private function createCustomer($data)
    {
        return $this->repository->create($data);
    }

}
