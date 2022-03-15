<?php

use App\Models\Damage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DamageFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Damage::factory()->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $damage = Damage::factory()->create();
        $damages = Damage::filter(['ids' => [$damage->id]]);
        $this->assertCount(1, $damages);
    }

}
