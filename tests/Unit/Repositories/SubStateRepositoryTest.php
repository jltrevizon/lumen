<?php

use App\Models\Company;
use App\Models\State;
use App\Models\SubState;
use App\Repositories\SubStateRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SubStateRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new SubStateRepository();
    }

    /** @test */
    public function it_can_create_a_sub_state_correctly()
    {
        $state = State::factory()->create();
        $name = 'Test Sub State';
        $request = new Request();
        $request->replace(['name' => $name, 'state_id' => $state->id]);
        $result = $this->repository->create($request);
        $this->assertEquals($name, $result['name']);
        $this->assertEquals($state->id, $result['state_id']);
    }

    /** @test */
    public function should_return_two_sub_states()
    {
        SubState::factory()->create();
        SubState::factory()->create();
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(SubState::count(), $result);
    }

    /** @test */
    public function should_return_zero_sub_states()
    {
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(0, []);
    }

    /** @test */
    public function should_return_a_sub_state_by_id()
    {
        $subState = SubState::factory()->create();
        $result = $this->repository->getById($subState->id);
        $this->assertEquals($subState->id, $result['sub_state']['id']);
        $this->assertEquals($subState->company_id, $result['sub_state']['company_id']);
        $this->assertEquals($subState->name, $result['sub_state']['name']);
    }

    /** @test */
    public function should_updated_a_sub_state_correctly()
    {
        $name = 'Test Update Sub State';
        $subState = SubState::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $subState->id);
        $this->assertEquals($subState->id, $result['sub_state']['id']);
        $this->assertEquals($name, $result['sub_state']['name']);
        $this->assertEquals($subState->company_id, $result['sub_state']['company_id']);
    }

    /** @test */
    public function should_delete_a_sub_state()
    {
        $subState = SubState::factory()->create();
        $result = $this->repository->delete($subState->id);
        $this->assertEquals('Sub state deleted', $result['message']);
    }

}
