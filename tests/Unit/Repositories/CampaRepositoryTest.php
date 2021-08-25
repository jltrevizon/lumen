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
        $this->assertEquals($result['name'], $request['name']);
        $this->assertNotEquals($result['id'], $request['id']);
    }

    /** @test */
    public function should_return_two_campas()
    {
        Campa::factory()->create();
        Campa::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result);
    }

    /** @test */
    public function should_return_zero_campas()
    {
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(0, $result);
    }

    /** @test */
    public function should_return_a_campa_by_id()
    {
        $campa = Campa::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getById($request, $campa->id);
        $this->assertEquals($campa['name'], $result['name']);
    }

    private function createCampa($data)
    {
        return $this->repository->create($data);
    }

}
