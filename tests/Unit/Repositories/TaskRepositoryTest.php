<?php

use App\Models\Company;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TaskRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TaskRepository();
    }

    /** @test */
    public function it_can_create_a_task_correctly()
    {
        $company = Company::factory()->create();
        $subState = SubState::factory()->create();
        $typeTask = TypeTask::factory()->create();
        $request = new Request();
        $name = 'Test Task';
        $duration = random_int(0, 9);
        $request->replace([
            'company_id' => $company->id,
            'sub_state_id' => $subState->id,
            'type_task_id' => $typeTask->id,
            'name' => $name,
            'duration' => $duration
        ]);
        $result = $this->repository->create($request);
        $this->assertEquals($company->id, $result['company_id']);
        $this->assertEquals($subState->id, $result['sub_state_id']);
        $this->assertEquals($typeTask->id, $result['type_task_id']);
        $this->assertEquals($name, $result['name']);
        $this->assertEquals($duration, $result['duration']);
    }

    /** @test */
    public function should_return_zero_tasks()
    {
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(0, 0);
    }

    /** @test */
    public function should_return_two_tasks()
    {
        Task::factory()->create();
        Task::factory()->create();
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(Task::count(), $result);
    }

    /** @test */
    public function should_return_a_task_by_id()
    {
        $request = new Request();
        $task = Task::factory()->create();
        $result = $this->repository->getById($request, $task->id);
        $this->assertEquals($task->id, $result['id']);
        $this->assertEquals($task->company_id, $result['company_id']);
        $this->assertEquals($task->sub_state_id, $result['sub_state_id']);
        $this->assertEquals($task->name, $result['name']);
        $this->assertEquals($task->type_task_id, $result['type_task_id']);
    }

    /** @test */
    public function should_updated_a_task_correctly()
    {
        $name = 'Test Update Task';
        $task = Task::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $task->id);
        $this->assertEquals($name, $result['task']['name']);
        $this->assertNotEquals($task->name, $result['task']['name']);
        $this->assertEquals($task->sub_state_id, $result['task']['sub_state_id']);
        $this->assertEquals($task->company_id, $result['task']['company_id']);
    }

    /** @test */
    public function should_delete_a_task()
    {
        $task = Task::factory()->create();
        $result = $this->repository->delete($task->id);
        $this->assertEquals('Task deleted', $result['message']);
    }

    /** @test */
    public function should_return_task_by_company()
    {
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        Task::factory()->create(['company_id' => $company1->id]);
        Task::factory()->create(['company_id' => $company1->id]);
        Task::factory()->create(['company_id' => $company2->id]);
        $result = $this->repository->getByCompany($company1->id);
        $this->assertCount(1, $result);
        $result = $this->repository->getByCompany($company2->id);
        $this->assertCount(1, $result);
    }
}
