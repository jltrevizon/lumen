<?php

use App\Models\Damage;
use App\Models\SeverityDamage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SeverityDamageTest extends TestCase
{
    
    use DatabaseTransactions;

    private SeverityDamage $severityDamage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->severityDamage = SeverityDamage::factory()->create();
    }

    /** @test */
    public function it_has_many_damages()
    {
        $this->assertInstanceOf(HasMany::class, $this->severityDamage->damages());
        $this->assertInstanceOf(Damage::class, $this->severityDamage->damages()->getModel());
    }

}
