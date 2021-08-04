<?php

use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Vehicle;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use phpDocumentor\Reflection\PseudoTypes\True_;

class GroupTaskRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->grouptask = GroupTask::factory()->create();
        $this->pendingtask = Pendingtask::factory()->create();
        $this->vehicle = Vehicle::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllGroupTask()
    {
        $response = $this->json('GET', 'api/grouptasks/getall')->assertResponseOk();
    }

    /**@test */
    public function testGroupTaskApprovedAvailable()
    {
        $response = $this->json('POST', 'api/grouptasks/approved-available', [
            'vehicle_id' => $this->pendingtask->vehicle_id,
            'group_task_id' => $this->pendingtask->group_task_id
        ]);
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testGroupTaskDecline()
    {
        $response = $this->json('POST', 'api/grouptasks/decline', [
            'vehicle_id' => $this->pendingtask->vehicle_id,
            'group_task_id' => $this->pendingtask->group_task_id
        ]);
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testGetGroupTaskById()
    {
        $response = $this->json('GET', 'api/grouptasks/'.$this->grouptask->id)->assertResponseOk();
    }

    /**@test */
    public function testCreateGroupTask()
    {
        $response = $this->json('POST', 'api/grouptasks',[
            'vehicle_id' => $this->vehicle->id,
            'approved' => rand(0,1),
            'approved_available' => rand(0,1)
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdateGroupTask()
    {
        $response = $this->json('PUT', 'api/grouptasks/update/'.$this->grouptask->id ,[
            'approved' => true,
        ])->assertResponseOk();

        $this->assertEquals(true, $this->grouptask->fresh()->approved);
    }

    /**@test */
    public function testDeleteGroupTask()
    {
        $response = $this->json('DELETE', '/api/grouptasks/delete/'.$this->grouptask->id)->assertResponseOk();

        $this->assertNull($this->grouptask->fresh());
    }
}
