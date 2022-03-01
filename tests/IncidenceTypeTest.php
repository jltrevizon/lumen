<?php

use App\Models\Incidence;
use App\Models\IncidenceType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncidenceTypeTest extends TestCase
{
  
    private IncidenceType $incidenceType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->incidenceType = IncidenceType::factory()->create();
    }

    /** @test */
    public function it_has_many_incidences()
    {
        $this->assertInstanceOf(HasMany::class, $this->incidenceType->incidences());
        $this->assertInstanceOf(Incidence::class, $this->incidenceType->incidences()->getModel());
    }

}
