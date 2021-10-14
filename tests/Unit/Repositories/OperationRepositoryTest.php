<?php

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\PendingTask;
use App\Models\Vehicle;
use App\Repositories\OperationRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OperationRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new OperationRepository();
    }

    /** @test */
    public function should_two_operations()
    {
        Operation::factory()->create();
        Operation::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result);
    }

    /** @test */
    public function should_return_a_operation_by_id()
    {
        $operation = Operation::factory()->create();
        $request = new Request();
        $result = $this->repository->getById($request, $operation->id);
        $this->assertEquals($operation->id, $result['id']);
    }

    /** @test */
    public function should_create_a_operation_correctly()
    {
        $vehicle = Vehicle::factory()->create();
        $pendingTask = PendingTask::factory()->create();
        $operationType = OperationType::factory()->create();
        $description = 'Description of operation';
        $request = new Request();
        $request->replace([
            'vehicle_id' => $vehicle->id,
            'pending_task_id' => $pendingTask->id,
            'operation_type_id' => $operationType->id,
            'description' => $description
        ]);
        $result = $this->repository->create($request);
        $this->assertEquals($vehicle->id, $result['vehicle_id']);
        $this->assertEquals($pendingTask->id, $result['pending_task_id']);
        $this->assertEquals($operationType->id, $result['operation_type_id']);
        $this->assertEquals($description, $result['description']);
    }

    /** @test */
    public function should_update_a_operation_correctly()
    {
        $operation = Operation::factory()->create();
        $description = 'Description of operation';
        $request = new Request();
        $request->replace(['description' => $description]);
        $result = $this->repository->update($request, $operation->id);
        $this->assertEquals($description, $result['description']);
    }

}
