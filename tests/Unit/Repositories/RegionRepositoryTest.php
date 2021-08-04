<?php

use App\Models\Region;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegionRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->region = Region::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllRegion()
    {
        $response = $this->json('GET', 'api/regions/getall')->assertResponseOk();
    }

    /**@test */
    public function testGetRegionById()
    {
        $response = $this->json('GET', 'api/regions/'.$this->region->id)->assertResponseOk();
    }

    /**@test */
    public function testCreateRegion()
    {
        $response = $this->json('POST', 'api/regions',[
            'name' => 'Testing region'
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdateRegion()
    {
        $response = $this->json('PUT', 'api/regions/update/'.$this->region->id,[
            'name' => 'Testing update'
        ])->assertResponseOk();

        $this->assertEquals('Testing update', $this->region->fresh()->name);
        $this->seeInDatabase('regions', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteRegion()
    {
        $response = $this->json('DELETE', '/api/regions/delete/'.$this->region->id)->assertResponseOk();

        $this->assertNull($this->region->fresh());
    }
}
