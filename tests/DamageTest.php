<?php

use App\Models\Campa;
use App\Models\Comment;
use App\Models\Damage;
use App\Models\DamageImage;
use App\Models\DamageType;
use App\Models\GroupTask;
use App\Models\PendingAuthorization;
use App\Models\Role;
use App\Models\SeverityDamage;
use App\Models\StatusDamage;
use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DamageTest extends TestCase
{
   
    use DatabaseTransactions;

    private Damage $damage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->damage = Damage::factory()->create();
    }

    /** @test */
    public function it_belongs_to_campa()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->campa());
        $this->assertInstanceOf(Campa::class, $this->damage->campa()->getModel());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->user());
        $this->assertInstanceOf(User::class, $this->damage->user()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->damage->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_group_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->groupTask());
        $this->assertInstanceOf(GroupTask::class, $this->damage->groupTask()->getModel());
    }

    /** @test */
    public function it_belongs_to_damage_type()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->damageType());
        $this->assertInstanceOf(DamageType::class, $this->damage->damageType()->getModel());
    }

    /** @test */
    public function it_belongs_to_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->task());
        $this->assertInstanceOf(Task::class, $this->damage->task()->getModel());
    }

    /** @test */
    public function it_has_many_comments()
    {
        $this->assertInstanceOf(HasMany::class, $this->damage->comments());
        $this->assertInstanceOf(Comment::class, $this->damage->comments()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_roles()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->damage->roles());
        $this->assertInstanceOf(Role::class, $this->damage->roles()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_tasks()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->damage->tasks());
        $this->assertInstanceOf(Task::class, $this->damage->tasks()->getModel());
    }

    /** @test */
    public function it_belongs_to_status_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->statusDamage());
        $this->assertInstanceOf(StatusDamage::class, $this->damage->statusDamage()->getModel());
    }

    /** @test */
    public function it_belongs_to_severity_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->severityDamage());
        $this->assertInstanceOf(SeverityDamage::class, $this->damage->severityDamage()->getModel());
    }

    /** @test */
    public function it_has_many_damage_image()
    {
        $this->assertInstanceOf(HasMany::class, $this->damage->damageImages());
        $this->assertInstanceOf(DamageImage::class, $this->damage->damageImages()->getModel());
    }

    /** @test */
    public function it_has_many_pending_authorizations()
    {
        $this->assertInstanceOf(HasMany::class, $this->damage->pendingAuthorizations());
        $this->assertInstanceOf(PendingAuthorization::class, $this->damage->pendingAuthorizations()->getModel());
    }
    
    /** @test */
    public function should_return_damages_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byIds([]));
    }

    /** @test */
    public function should_return_damages_by_vehicle_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byVehicleIds([]));
    }

    /** @test */
    public function should_return_damages_by_task_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byTaskIds([]));
    }


    /** @test */
    public function should_return_damages_by_status_damage_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byIds([]));
    }

    /** @test */
    public function should_return_damage_by_plate()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byPlate(''));
    }

    /** @test */
    public function should_return_damage_by_severity_damage_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->bySeverityDamageIds([]));
    }
}
