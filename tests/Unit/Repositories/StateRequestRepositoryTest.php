<?php

use App\Models\StateRequest;
use App\Repositories\StateRequestRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateRequestRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StateRequestRepository();
    }

    /** @test */
    public function it_can_create_a_state_request_correctly()
    {
        $name = 'Test State Request';
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->create($request);
        $this->assertEquals($name, $result['name']);
    }

    /** @test */
    public function should_return_a_state_request_by_id()
    {
        $stateRequest = StateRequest::factory()->create();
        $result = $this->repository->getById($stateRequest->id);
        $this->assertEquals($stateRequest['id'], $result['state_request']['id']);
        $this->assertEquals($stateRequest['name'], $result['state_request']['name']);
    }

    /** @test */
    public function should_updated_a_state_request_correclty()
    {
        $name = 'Test Updated State Request';
        $stateRequest = StateRequest::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $stateRequest->id);
        $this->assertEquals($stateRequest['id'], $result['state_request']['id']);
        $this->assertEquals($name, $result['state_request']['name']);
    }

    /** @test */
    public function should_delete_a_state_request()
    {
        $stateRequest = StateRequest::factory()->create();
        $result = $this->repository->delete($stateRequest->id);
        $this->assertEquals('State request deleted', $result['message']);
    }

}
