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
    }

    /** @test */
    public function should_return_zero_companies()
    {
        $companies = $this->repository->getAll();
        $this->assertCount(0, $companies);
    }

    /** @test */
    public function should_return_two_companies()
    {
        Company::where('id','>', 0)->delete();
        $company = Company::factory()->create();
        $request = new Request();
        $request->replace(['name' => $company['name']]);

        $company = Company::factory()->create();
        $request = new Request();
        $request->replace(['name' => $company['name']]);

        $companies = $this->repository->getAll();
        $this->assertCount(2, $companies);
    }

    private function createCompany($data)
    {
        return $this->repository->create($data);
    }

}
