<?php

use App\Models\PeopleForReport;
use App\Models\TypeReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PeopleForReportTest extends TestCase
{

    use DatabaseTransactions;

    private PeopleForReport $peopleForReport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->peopleForReport = PeopleForReport::factory()->create();
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->peopleForReport->user());
        $this->assertInstanceOf(User::class, $this->peopleForReport->user()->getModel());
    }


    /** @test */
    public function it_belongs_to_type_report_id()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->peopleForReport->typeReport());
        $this->assertInstanceOf(TypeReport::class, $this->peopleForReport->typeReport()->getModel());
    }

}
