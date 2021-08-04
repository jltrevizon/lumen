<?php

use App\Models\Company;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompanyRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllCompany()
    {
        $response = $this->json('GET', 'api/companies/getall');
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testGetCompanyById()
    {
        $response = $this->json('GET', 'api/companies/'.$this->company->id);
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testCreateCompany()
    {
        $response = $this->json('POST', 'api/companies',[
            'name' => 'Testing create',
            'tradename' => 'Testing create',
            'nif' => 'Testing create',
            'address' => 'Testing create',
            'location' => 'Testing create',
            'phone' => '018303984',
            'logo' => 'Testing create',
        ]);
        $response->assertResponseStatus(201);
    }


    /**@test */
    public function testUpdateCompany()
    {
        $response = $this->json('PUT', 'api/companies/update/'.$this->company->id, [
            'name' => 'Testing update',
        ])->assertResponseStatus(200);

        $this->assertEquals('Testing update', $this->company->fresh()->name);
        $this->seeInDatabase('companies', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteCompany()
    {
        $response = $this->json('DELETE', '/api/companies/delete/'.$this->company ->id)->assertResponseStatus(200);

        $this->assertNull($this->company->fresh());
    }
}
