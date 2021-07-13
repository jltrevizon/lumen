<?php

use App\Models\Accessory;
use App\Models\Reception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryTest extends TestCase
{
    private Accessory $accessory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessory = Accessory::factory()->create();
    }

    /** @test */
    public function it_belongs_to_reception()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->accessory->reception());
        $this->assertInstanceOf(Reception::class, $this->accessory->reception()->getModel());
    }
}
