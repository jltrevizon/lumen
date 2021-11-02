<?php

use App\Models\Damage;
use App\Models\StatusDamage;
use App\Models\Task;
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
    public function should_return_damages_by_status_damage_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damage->byIds([]));
    }

}
