<?php

use App\Models\Accessory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Accessory::factory()->count(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $accessory = Accessory::factory()->create();
        $data = Accessory::filter(['ids' => [$accessory->id]])->get();
        $this->assertCount(1, $data);
    }

}
