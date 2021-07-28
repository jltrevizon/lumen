<?php

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\PendingTask;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OperationTest extends TestCase
{

    use DatabaseTransactions;

    private Operation $operation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operation = Operation::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->operation->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->operation->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_pending_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->operation->pendingTask());
        $this->assertInstanceOf(PendingTask::class, $this->operation->pendingTask()->getModel());
    }

    /** @test */
    public function it_belongs_to_operation_type()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->operation->operationType());
        $this->assertInstanceOf(OperationType::class, $this->operation->operationType()->getModel());
    }
}
