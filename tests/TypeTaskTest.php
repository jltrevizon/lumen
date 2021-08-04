<?php

use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeTaskTest extends TestCase
{

    use DatabaseTransactions;

    private TypeTask $typeTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeTask = TypeTask::factory()->create();
    }

    /** @test */
    public function it_has_many_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeTask->tasks());
        $this->assertInstanceOf(Task::class, $this->typeTask->tasks()->getModel());
    }
}
