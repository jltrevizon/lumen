<?php

use App\Models\Campa;
use App\Models\Company;
use App\Models\Province;
use App\Models\Region;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CampaFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Campa::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $campa = Campa::factory()->create();    
        $campas = Campa::filter(['ids' => [$campa->id]])->get();
        $this->assertCount(1, $campas);
        $this->assertEquals($campa->id, $campas[0]->id);
    }

    /** @test */
    public function it_can_filter_by_companies()
    {
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        Campa::query()->update(['company_id' => $company1->id]);
        $campa = Campa::factory()->create(['company_id' => $company2->id]);   
        $campas = Campa::filter(['companies' => [$campa->company_id]])->get();
        $this->assertCount(1, $campas);
        $this->assertEquals($campa->id, $campas[0]->id);
    }

    /** @test */
    public function it_can_filter_by_provinces()
    {
        $province1 = Province::factory()->create();
        $province2 = Province::factory()->create();
        Campa::query()->update(['province_id' => $province1->id]);
        $campa = Campa::factory()->create(['province_id' => $province2->id]);   
        $campas = Campa::filter(['provinces' => [$campa->province_id]])->get();
        $this->assertCount(1, $campas);
        $this->assertEquals($campa->id, $campas[0]->id);
    }

    /** @test */
    public function it_can_filter_by_region()
    {
        $region1 = Region::factory()->create();
        $region2 = Region::factory()->create();
        $campa = Campa::factory()->create();
        Province::query()->update(['region_id' => $region1->id]);
        Province::query()->where('id', $campa->province_id)->update(['region_id' => $region2->id]);
        $campas = Campa::filter(['regions' => [$region2->id]])->get();
        $this->assertCount(1, $campas);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        Campa::query()->update(['name' => 'Campa 1']);
        $campa = Campa::factory()->create(['name' => 'Campa 2']);
        $campas = Campa::filter(['name' => $campa->name])->get();
        $this->assertCount(1, $campas);
    }

}
