<?php

use App\Models\Campa;
use App\Models\Company;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CampaRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->region = Region::factory()->create();
        $this->province = Province::factory()->create();
        $this->company = Company::factory()->create();
        $this->campa = Campa::factory()->create();
        $this->user = $this->signIn();
    }

    // /**@test */
    // public function testGetAllCampa()
    // {
    //     $response = $this->json('GET', 'api/campas/getall');
    //     $response->assertResponseStatus(200);
    // }

    // /**@test */
    // public function testGetCampaById()
    // {
    //     $response = $this->json('GET', 'api/campas/'.$this->campa->id);
    //     $response->assertResponseStatus(200);

    // }

    // /**@test */
    // public function testGetCampaByComapny()
    // {
    //     $response = $this->json('POST', 'api/campas/by-company',[
    //         'company_id' => $this->company->id
    //     ]);
    //     $response->assertResponseStatus(200);
    // }

    // /**@test */
    // public function testGetCampaByRegion()
    // {
    //     $response = $this->json('POST', 'api/campas/by-region',[
    //         'region_id' => $this->region->id,
    //         'company_id' => $this->company->id
    //     ]);
    //     $response->assertResponseStatus(200);
    // }

    // /**@test */
    // public function testGetCampaByProvince()
    // {
    //     $response = $this->json('POST', 'api/campas/by-region',[
    //         'region_id' => $this->region->id,
    //         'company_id' => $this->company->id
    //     ]);
    //     $response->assertResponseStatus(200);
    // }

    // /**@test */
    // public function testCreateCampa()
    // {
    //     $response = $this->json('POST', 'api/campas', [
    //         'company_id' => $this->company->id,
    //         'name' => 'Testing create',
    //     ])->assertResponseStatus(201);

    //     $this->seeInDatabase('campas', ['name'=>'Testing create']);
    // }

    // /**@test */
    // public function testUpdateCampa()
    // {
    //     $response = $this->json('PUT', 'api/campas/update/'.$this->campa->id, [
    //         'name' => 'Testing update',
    //     ])->assertResponseStatus(200);

    //     $this->assertEquals('Testing update', $this->campa->fresh()->name);
    //     $this->seeInDatabase('campas', ['name'=>'Testing update']);
    // }

    // /**@test */
    // public function testDeleteCampa()
    // {
    //     $response = $this->json('DELETE', '/api/campas/delete/'.$this->campa->id)->assertResponseStatus(200);

    //     $this->assertNull($this->campa->fresh());
    // }
}
