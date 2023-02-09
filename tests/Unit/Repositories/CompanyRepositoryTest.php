<?php

use App\Models\Company;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompanyRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CompanyRepository();
    }

    /** @test */
    public function it_can_create_a_company_correctly()
    {
        $company = Company::factory()->create();
        $request = new Request();
        $request->replace(['name' => $company['name']]);
        $result = $this->createCompany($request);
        $this->assertEquals($result['name'], $company['name']);
        $this->assertNotEquals($result['id'], $company['id']);
    }

    /** @test */
    public function should_return_two_companies()
    {
        Company::factory()->create();

        Company::factory()->create();
        $request = new Request();
        $request->with = [];
        $companies = $this->repository->index($request);
        $this->assertCount(Company::count(), $companies->items());
    }

    /** @test */
    public function should_return_zero_companies()
    {
        $request = new Request();
        $request->with = [];
        $companies = $this->repository->index($request);
        $this->assertCount(0, []);
    }

    /** @test */
    public function should_return_company_by_id()
    {
        $company = Company::factory()->create();

        $getCompany = $this->repository->show($company->id);

        $this->assertEquals($company['name'], $getCompany['name']);
        $this->assertEquals($company['tradename'], $getCompany['tradename']);
        $this->assertEquals($company['nif'], $getCompany['nif']);
        $this->assertEquals($company['phone'], $getCompany['phone']);
    }

    /** @test */
    public function should_updated_correctly()
    {
        $name = 'Prueba Update Company';
        $company = Company::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);

        $updateCompany = $this->repository->update($request, $company->id);

        $this->assertEquals($name, $updateCompany['company']['name']);
    }

    private function createCompany($data)
    {
        return $this->repository->create($data);
    }

}
