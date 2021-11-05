<?php

use App\Models\DamageImage;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DamageImageTest extends TestCase
{
    
    use DatabaseTransactions;

    private DamageImage $damageImage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->damageImage = DamageImage::factory()->create();
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damageImage->user());
        $this->assertInstanceOf(User::class, $this->damageImage->user()->getModel());
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damageImage->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->damageImage->vehicle()->getModel());
    }

    /** @test */
    public function should_return_damage_images_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byIds([]));
    }

    /** @test */
    public function should_return_damage_images_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byUserIds([]));
    }

    /** @test */
    public function should_return_damage_images_by_vehicle_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byVehicleIds([]));
    }

    /** @test */
    public function should_return_damage_images_by_plate()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byPlate(''));
    }
}
