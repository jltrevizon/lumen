<?php

use App\Models\Incidence;
use App\Repositories\IncidenceRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncidenceRepositoryTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new IncidenceRepository();
    }

    /** @test */
    public function should_two_incidences()
    {
        Incidence::factory()->create();
        Incidence::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function should_return_a_incidence_by_id()
    {
        $incidence = Incidence::factory()->create();
        $result = $this->repository->getById($incidence->id);
        $this->assertEquals($incidence->id, $result['id']);
    }

    /** @test */
    public function should_create_a_incidence_correctly()
    {
        $description = 'Description incidence';
        $request = new Request();
        $request->replace([
            'description' => $description
        ]);
        $result = $this->repository->create($request);
        $this->assertEquals($description, $result['description']);
        $this->assertEquals($result['resolved'], false);
    }

    /** @test */
    public function should_resolved_a_incidence()
    {
        $incidence = Incidence::factory()->create();
        $request = new Request();
        $request->replace([
            'incidence_id' => $incidence->id
        ]);
        $result = $this->repository->resolved($request);
        $this->assertEquals($result['resolved'], true);
    }

    /** @test */
    public function should_update_a_incidence()
    {
        $description = 'Description test incidence';
        $incidence = Incidence::factory()->create();
        $request = new Request();
        $request->replace(['description' => $description]);
        $result = $this->repository->update($request, $incidence->id);
        $this->assertEquals($description, $result['incidence']['description']);
    }

    /** @test */
    public function should_delete_a_incidence()
    {
        $incidence = Incidence::factory()->create();
        $result = $this->repository->delete($incidence->id);
        $this->assertEquals('Incidence deleted', $result['message']);
    }

}
