<?php

use App\Models\Company;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompanyFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Company::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $company = Company::factory()->create();
        $companies = Company::filter(['ids' => [$company->id]])->get();
        $this->assertCount(1, $companies);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        Company::query()->update(['name' => 'Company 2']);
        $company = Company::factory()->create(['name' => 'Company 1']);
        $companies = Company::filter(['name' => $company->name])->get();
        $this->assertCount(1, $companies);
    }

    /** @test */
    public function it_can_filter_by_nif()
    {
        Company::query()->update(['nif' => 'A0000000']);
        $company = Company::factory()->create(['nif' => 'A00000001']);
        $companies = Company::filter(['nif' => $company->nif])->get();
        $this->assertCount(1, $companies);
    }

    /** @test */
    public function it_can_filter_by_phone()
    {
        Company::query()->update(['phone' => 600000000]);
        $company = Company::factory()->create(['phone' => 600000001]);
        $companies = Company::filter(['phone' => $company->phone])->get();
        $this->assertCount(1, $companies);
    }

}
