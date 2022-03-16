<?php

use App\Models\State;
use App\Models\SubState;
use App\Models\SubStateChangeHistory;
use App\Models\Task;
use App\Models\TypeUserApp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SubStateTest extends TestCase
{

    use DatabaseTransactions;

    private SubState $subState;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subState = SubState::factory()->create();
    }

    /** @test */
    public function it_belongs_to_state()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->subState->state());
        $this->assertInstanceOf(State::class, $this->subState->state()->getModel());
    }

    /** @test */
    public function it_has_many_tasks()
    {
        $this->assertInstanceOf(HasMany::class, $this->subState->tasks());
        $this->assertInstanceOf(Task::class, $this->subState->tasks()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_type_users_app()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->subState->type_users_app());
        $this->assertInstanceOf(TypeUserApp::class, $this->subState->type_users_app()->getModel());
    }

    /** @test */
    public function it_has_many_sub_state_change_histories()
    {
        $this->assertInstanceOf(HasMany::class, $this->subState->subStateChangeHistories());
        $this->assertInstanceOf(SubStateChangeHistory::class, $this->subState->subStateChangeHistories()->getModel());
    }

    /** @test */
    public function should_return_sub_states_by_state_id()
    {
        $this->assertInstanceOf(Builder::class, $this->subState->byStateIds([]));
    }

    /** @test */
    public function should_return_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->subState->byIds([]));
    }
}
