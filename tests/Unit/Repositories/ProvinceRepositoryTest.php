<?php

use App\Models\Province;
use App\Models\Region;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProvinceRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->province = Province::factory()->create();
        $this->region = Region::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllProvince()
    {
        $response = $this->json('GET', 'api/provinces/getall')->assertResponseOk();
    }

    /**@test */
    public function testGetProvinceById()
    {
        $response = $this->json('GET', 'api/provinces/'.$this->province->id)->assertResponseOk();
    }

    /**@test */
    public function testCreateProvince()
    {
        $response = $this->json('POST', 'api/provinces',[
            'region_id' => $this->region->id,
            'province_code' => '123456',
            'name' => 'Testing province'
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdateProvince()
    {
        $response = $this->json('PUT', 'api/provinces/update/'.$this->province->id,[
            'name' => 'Testing update'
        ])->assertResponseOk();

        $this->assertEquals('Testing update', $this->province->fresh()->name);
        $this->seeInDatabase('provinces', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteProvince()
    {
        $response = $this->json('DELETE', '/api/provinces/delete/'.$this->province->id)->assertResponseOk();

        $this->assertNull($this->province->fresh());
    }
}
