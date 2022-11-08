<?php

use App\Models\Campa;
use App\Repositories\CampaRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CampaRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CampaRepository();
    }

    /** @test */
    public function it_can_create_a_campa_correctly()
    {
        $campa = Campa::factory()->create();
        $request = new Request();
        $request->replace(['name' => $campa['name'], 'company_id' => $campa['company_id']]);
        $result = $this->createCampa($request);
        $this->assertEquals($result['campa']['name'], $request['name']);
        $this->assertNotEquals($result['campa']['id'], $request['id']);
    }

    /** @test */
    public function should_return_two_campas()
    {
        Campa::factory()->create();
        Campa::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->index($request);
        $this->assertCount(Campa::count(), $result);
    }

    /** @test */
    public function should_return_zero_campas()
    {
        $request = new Request();
        $request->with = [];
        $result = $this->repository->index($request);
        $this->assertCount(0, []);
    }

    /** @test */
    public function should_return_a_campa_by_id()
    {
        $campa = Campa::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->show($request, $campa->id);
        $this->assertEquals($campa['name'], $result['name']);
    }

    /** @test */
    public function should_return_a_campa_by_name()
    {
        $campa = Campa::factory()->create();
        $result = $this->repository->getByName($campa->name);
        $this->assertEquals($campa->id, $result['id']);
        $this->assertEquals($campa->name, $result['name']);
    }

    /** @test */
    public function should_update_a_campa_correctly()
    {
        $campa = Campa::factory()->create();
        $request = new Request();
        $request->replace(['name' => 'Campa prueba 1']);
        $result = $this->repository->update($request, $campa->id);
        $this->assertEquals($campa->id, $result['campa']['id']);
        $this->assertNotEquals($campa->name, $result['campa']['name']);
    }

    private function createCampa($data)
    {
        return $this->repository->create($data);
    }

}
