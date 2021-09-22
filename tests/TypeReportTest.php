<?php

use App\Models\PeopleForReport;
use App\Models\TypeReport;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeReportTest extends TestCase
{

    use DatabaseTransactions;

    private TypeReport $typeReport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeReport = TypeReport::factory()->create();
    }

    /** @test */
    public function it_has_many_people_for_reports()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeReport->peopleForReports());
        $this->assertInstanceOf(PeopleForReport::class, $this->typeReport->peopleForReports()->getModel());
    }

}
