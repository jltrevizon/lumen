<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
        $this->customer = Customer::factory()->create();
        $this->province = Province::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllCustomer()
    {
        $response = $this->json('GET', 'api/customers/getall');
        $response->assertResponseOk();
    }

    /**@test */
    public function testGetcustomerById()
    {
        $response = $this->json('GET', 'api/customers/'.$this->customer->id);
        $response->assertResponseOk();
    }

    /**@test */
    public function testCreateCustomer()
    {
        $response = $this->json('POST', 'api/customers',[
            'name' => 'Testing create',
            'company_id' => $this->company->id,
            'province_id' => $this->province->id,
            'cif' => 'Tesing',
            'phone' => '2733',
            'address' =>'Testing'
        ]);
        $response->assertResponseStatus(201);
    }

    public function testGetuserByCompany()
    {
        $response = $this->json('POST', 'api/customers/by-company',[
            'company_id' => $this->company->id
        ])->assertResponseOk();
    }

    /**@test */
    public function testUpdateCustomer()
    {
        $response = $this->json('PUT', 'api/customers/update/'.$this->customer->id, [
            'name' => 'Testing update',
        ])->assertResponseOk();

        $this->assertEquals('Testing update', $this->customer->fresh()->name);
        $this->seeInDatabase('customers', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteCustomer()
    {
        $response = $this->json('DELETE', '/api/customers/delete/'.$this->customer->id)->assertResponseOk();

        $this->assertNull($this->customer->fresh());
    }
}
