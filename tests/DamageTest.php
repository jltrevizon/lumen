<?php

use App\Models\Damage;
use App\Models\SeverityDamage;
use App\Models\StatusDamage;
use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->user());
        $this->assertInstanceOf(User::class, $this->damage->user()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicles()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->damage->vehicle()->getModel());
    }

    /** @test */
    public function it_belongs_to_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->task());
        $this->assertInstanceOf(Task::class, $this->damage->task()->getModel());
    }

    /** @test */
    public function it_belongs_to_status_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->statusDamage());
        $this->assertInstanceOf(StatusDamage::class, $this->damage->statusDamage()->getModel());
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
    public function it_belongs_to_severity_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damage->severityDamage());
        $this->assertInstanceOf(SeverityDamage::class, $this->damage->severityDamage()->getModel());
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
