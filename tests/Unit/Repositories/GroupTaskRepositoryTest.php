<?php

use App\Mail\NotificationDAMail;
use App\Models\GroupTask;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\GroupTaskRepository;
use App\Repositories\PendingTaskRepository;
use App\Repositories\StateChangeRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GroupTaskRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stateChangeRepository = new StateChangeRepository();
        $this->notificationDAMail = new NotificationDAMail();
        $this->repository = new GroupTaskRepository($this->stateChangeRepository, $this->notificationDAMail);
    }

    /** @test */
    public function should_return_two_group_tasks()
    {
        GroupTask::factory()->create();
        GroupTask::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function should_return_a_group_tasks_by_id()
    {
        $request = new Request();
        $request->with = [];
        $groupTask1 = GroupTask::factory()->create();
        $groupTask2 = GroupTask::factory()->create();
        $result = $this->repository->getById($request, $groupTask1->id);
        $this->assertEquals($groupTask1->id, $result['id']);
        $this->assertNotEquals($groupTask2->id, $result['id']);
    }

    /** @test */
    public function should_create_a_group_task_with_vehicle_id()
    {
        $vehicle = Vehicle::factory()->create();
        $result = $this->repository->create([
            'vehicle_id' => $vehicle->id
        ]);
        $this->assertEquals($vehicle->id, $result['vehicle_id']);
    }

    /** @test */
    public function should_create_a_group_task_correctly()
    {
        $vehicle = Vehicle::factory()->create();
        $request = new Request();
        $request->replace(['vehicle_id' => $vehicle->id]);
        $result = $this->repository->create($request);
        $this->assertEquals($vehicle->id, $result['vehicle_id']);
        $this->assertEquals($result['approved'], false);
    }

    /** @test */
    public function should_create_a_group_task_approved()
    {
        $vehicle = Vehicle::factory()->create();
        $request = new Request();
        $request->replace(['vehicle_id' => $vehicle->id]);
        $result = $this->repository->create([
            'vehicle_id' => $vehicle->id,
            'approved_available' => 1,
            'approved' => 1
        ]);
        $this->assertEquals($vehicle->id, $result['vehicle_id']);
        $this->assertEquals($result['approved'], true);
    }

    /** @test */
    public function should_update_a_group_task_correctly()
    {
        $vehicle = Vehicle::factory()->create();
        $groupTask = GroupTask::factory()->create();
        $request = new Request();
        $request->replace([
            'vehicle_id' => $vehicle->id,
        ]);
        $result = $this->repository->update($request, $groupTask->id);
        $this->assertEquals($vehicle->id, $result['group_task']['vehicle_id']);
    }

    /** @test */
    public function should_return_last_group_task_by_vehicle()
    {
        $vehicle = Vehicle::factory()->create();
        $groupTask1 = GroupTask::factory()->create(['vehicle_id' => $vehicle->id]);
        $groupTask2 = GroupTask::factory()->create(['vehicle_id' => $vehicle->id]);
        $result = $this->repository->getLastByVehicle($vehicle->id);
        $this->assertEquals($groupTask2->id, $result['id']);
        $this->assertNotEquals($groupTask1->id, $result['id']);
    }

    /** @test */
    public function should_approved_group_task_approved_to_available()
    {
        /* $groupTask = GroupTask::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);
        $vehicle = Vehicle::factory()->create();
        $request = new Request();
        $request->replace(['group_task_id' => $groupTask->id, 'vehicle_id' => $vehicle->id]);
        $result = $this->repository->approvedGroupTaskToAvailable($request);
        $this->assertEquals('Solicitud aprobada!', $result['message']);*/
    }

    /** @test */
    public function should_decline_a_group_task()
    {
        /* $groupTask = GroupTask::factory()->create();
        $request = new Request();
        $request->replace(['vehicle_id' => $groupTask->vehicle_id, 'group_task_id' => $groupTask->id]);
        $result = $this->repository->declineGroupTask($request);
        $this->assertEquals('Solicitud declinada!', $result['message']);*/
    }
}
