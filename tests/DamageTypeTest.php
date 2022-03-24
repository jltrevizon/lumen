<?php

use App\Models\Damage;
use App\Models\DamageType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DamageTypeTest extends TestCase
{
    
    use DatabaseTransactions;

    private DamageType $damageType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->damageType = DamageType::factory()->create();
    }

    /** @test */
    public function it_has_many_damages()
    {
        $this->assertInstanceOf(HasMany::class, $this->damageType->damages());
        $this->assertInstanceOf(Damage::class, $this->damageType->damages()->getModel());
    }

}
