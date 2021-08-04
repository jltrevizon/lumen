<?php

use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\PendingTaskCanceled;
use App\Models\StatePendingTask;
use App\Models\Task;
use App\Models\Vehicle;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingTaskRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->grouptask = GroupTask::factory()->create();
        $this->pendingtask = PendingTask::factory()->create();
        $this->pendingtaskcanceled = PendingTaskCanceled::factory()->create();
        $this->statependingtask = StatePendingTask::factory()->create();
        $this->task = Task::factory()->create();
        $this->vehicle = Vehicle::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllPendingTask()
    {
        $response = $this->json('GET', 'api/pending-tasks/getall')->assertResponseOk();
    }

    /**@test */
    public function testPendingTaskPenginOrNext()
    {
        $response = $this->json('GET', 'api/pending-tasks')->assertResponseOk();
    }

    /**@test */
    public function testCreatePendingTask()
    {
        $response = $this->json('POST', 'api/pending-tasks', [
            'vehicle_id' => $this->vehicle->id,
            'task_id' => $this->task->id,
            'state_pending_task_id' => $this->statependingtask->id,
            'group_task_id' => $this->grouptask->id,
            'duration' => '5',
            'order' => rand(1,20),
            'code_authorization' => '123456',
            'status_color' => 'Test',
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdatePendingTask()
    {
        $response = $this->json('PUT', 'api/pending-tasks/update/'.$this->pendingtask->id, [
            'duration' => '9',
            'status_color' => 'Testing update',
        ])->assertResponseOk();

        $this->assertEquals('Testing update', $this->pendingtask->fresh()->status_color);
        $this->seeInDatabase('pending_tasks', ['status_color'=>'Testing update']);
    }

    /**@test */
    public function testDeletePendingTask()
    {
        $response = $this->json('DELETE', 'api/pending-tasks/delete/'.$this->pendingtask->id)->assertResponseOk();

        $this->assertNull($this->pendingtask->fresh());
    }

    /**@test */
    public function testStartPendingTask()
    {
        $response = $this->json('POST', 'api/pending-tasks/start-pending-task',[
            'pending_task_id' => $this->pendingtask->id
        ])->assertResponseOk();

    }

    /**@test */
    public function testCancelPendingTask()
    {
        $response = $this->json('POST', 'api/pending-tasks/cancel-pending-task', [
            'pending_task_id' => $this->pendingtask->id
        ])->assertResponseOk();
    }

    /**@test */
    public function testFinishPendingTask()
    {
        $response = $this->json('POST', 'api/pending-tasks/finish-pending-task', [
            'pending_task_id' => $this->pendingtask->state_pending_task_id
        ])->assertResponseOk();
    }

    /**@test */
    public function testPendingTaskIncedence()
    {
        $response = $this->json('POST', 'api/pending-tasks/incidence', [
            'pending_task_id' => $this->pendingtask->state_pending_task_id
        ])->assertResponseStatus(201);
    }
}
