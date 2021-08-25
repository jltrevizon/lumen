<?php

use App\Models\Company;
use App\Models\State;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StateRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StateRepository();
    }

    /** @test */
    public function it_can_create_a_state_correctly()
    {
        $name = 'Test State';
        $company = Company::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name, 'company_id' => $company->id]);
        $result = $this->repository->create($request);
        $this->assertEquals($name, $result['name']);
        $this->assertInstanceOf(State::class, $result);
    }

    /** @test */
    public function should_return_a_state_by_id()
    {
        $state = State::factory()->create();
        $result = $this->repository->getById($state->id);
        $this->assertEquals($state['name'], $result['state']['name']);
        $this->assertInstanceOf(State::class, $result['state']);
    }

    /** @test */
    public function should_return_two_states()
    {
        State::factory()->create();
        State::factory()->create();
        $result = $this->repository->getAll();
        $this->assertCount(2, $result);
    }

    /** @test */
    public function should_updated_a_state_correctly()
    {
        $name = 'Test Update State';
        $state = State::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $state->id);
        $this->assertEquals($name, $result['state']['name']);
    }

    /** @test */
    public function should_delete_a_state()
    {
        $state = State::factory()->create();
        $result = $this->repository->delete($state->id);
        $this->assertEquals('State deleted', $result['message']);
    }
}
