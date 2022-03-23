<?php

use App\Models\Accessory;
use App\Models\AccessoryType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryTypeTest extends TestCase
{

    use DatabaseTransactions;

    private AccessoryType $accessoryType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessoryType = AccessoryType::factory()->create();
    }

    /** @test */
    public function it_has_many_accessories()
    {
        $this->assertInstanceOf(HasMany::class, $this->accessoryType->accessories());
        $this->assertInstanceOf(Accessory::class, $this->accessoryType->accessories()->getModel());
    }

}
