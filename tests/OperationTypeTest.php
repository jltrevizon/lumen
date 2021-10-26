<?php

use App\Models\Operation;
use App\Models\OperationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OperationTypeTest extends TestCase
{

    use DatabaseTransactions;

    private OperationType $operationType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operationType = OperationType::factory()->create();
    }

    /** @test */
    public function it_has_many_operations()
    {
        $this->assertInstanceOf(HasMany::class, $this->operationType->operations());
        $this->assertInstanceOf(Operation::class, $this->operationType->operations()->getModel());
    }

    /** @test */
    public function should_return_operation_type_by_ods()
    {
        $this->assertInstanceOf(Builder::class, $this->operationType->byIds([]));
    }
}
