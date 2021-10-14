<?php

use App\Models\PendingTask;
use App\Repositories\PendingTaskCanceledRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingTaskCanceledRepositoryTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PendingTaskCanceledRepository();
    }

    /** @test */
    public function should_create_a_pending_task_canceled_correctly()
    {
        $pendingTask = PendingTask::factory()->create();
        $description = 'Description of pending task canceled';
        $request = new Request();
        $request->replace([
            'pending_task_id' => $pendingTask->id,
            'description' => $description
        ]);
        $result = $this->repository->create($request);
        $this->assertEquals($pendingTask->id, $result['pending_task_id']);
        $this->assertEquals($description, $result['description']);
    }

}
