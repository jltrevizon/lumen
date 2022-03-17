<?php

use App\Models\Accessory;
use App\Models\AccessoryType;
use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryTest extends TestCase
{
    use DatabaseTransactions;

    private Accessory $accessory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessory = Accessory::factory()->create();
    }

    /** @test */
    public function it_belongs_to_accessory_types()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->accessory->accessoryTypes());
        $this->assertInstanceOf(AccessoryType::class, $this->accessory->accessoryTypes()->getModel());
    }

    /** @test */
    public function it_belongs_to_many_vehicles()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->accessory->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->accessory->vehicles()->getModel());
    }

    /** @test */
    public function should_return_accessories_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->accessory->byIds([]));
    }
}
