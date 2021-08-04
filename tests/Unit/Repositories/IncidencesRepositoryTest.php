<?php

use App\Models\Incidence;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncidencesRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->incidence = Incidence::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllIncidence()
    {
        $response = $this->json('GET', 'api/incidences/getall')->assertResponseOk();
    }

    /**@test */
    public function testGetIncidenceById()
    {
        $response = $this->json('GET', 'api/incidences/'.$this->incidence->id)->assertResponseOk();
    }

    /**@test */
    public function testCreateIncidence()
    {
        $response = $this->json('POST', 'api/incidences',[
            'description' => 'Testing incidence',
            'resolved' => rand(0,1)
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdateIncidence()
    {
        $response = $this->json('PUT', 'api/incidences/update/'.$this->incidence->id,[
            'description' => 'Testing update',
            'resolved' => true
        ])->assertResponseOk();

        $this->assertEquals('Testing update', $this->incidence->fresh()->description);
        $this->seeInDatabase('incidences', ['description'=>'Testing update']);
    }

    /**@test */
    public function testDeleteIncidence()
    {
        $response = $this->json('DELETE', '/api/incidences/delete/'.$this->incidence->id)->assertResponseOk();

        $this->assertNull($this->incidence->fresh());
    }
}
