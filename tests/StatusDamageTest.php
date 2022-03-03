<?php

use App\Models\Damage;
use App\Models\StatusDamage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StatusDamageTest extends TestCase
{

    use DatabaseTransactions;

    private StatusDamage $statusDamage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->statusDamage = StatusDamage::factory()->create();
    }

    /** @test */
    public function it_has_many_damages()
    {
        $this->assertInstanceOf(HasMany::class, $this->statusDamage->damages());
        $this->assertInstanceOf(Damage::class, $this->statusDamage->damages()->getModel());
    }

}
