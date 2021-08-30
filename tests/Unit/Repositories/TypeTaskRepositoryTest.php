<?php

use App\Models\TypeTask;
use App\Repositories\TypeTaskRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeTaskRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TypeTaskRepository();
    }

    /** @test */
    public function it_can_create_a_type_task_correctly()
    {
        $name = 'Test Type Task';
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->create($request);
        $this->assertEquals($name, $result['name']);
    }

    /** @test */
    public function should_return_a_type_task_by_id()
    {
        $typeTask = TypeTask::factory()->create();
        $result = $this->repository->getById($typeTask->id);
        $this->assertEquals($typeTask->id, $result['type_task']['id']);
        $this->assertEquals($typeTask->name, $result['type_task']['name']);
    }

    /** @test */
    public function should_updated_a_type_task_correctly()
    {
        $name = 'Test Update Type Task';
        $typeTask = TypeTask::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $typeTask->id);
        $this->assertEquals($typeTask->id, $result['type_task']['id']);
        $this->assertEquals($name, $result['type_task']['name']);
    }

    /** @test */
    public function should_delete_a_type_task()
    {
        $typeTask = TypeTask::factory()->create();
        $result = $this->repository->delete($typeTask->id);
        $this->assertEquals('Type task deleted', $result['message']);
    }
}
