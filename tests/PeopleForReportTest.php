<?php

use App\Models\PeopleForReport;
use App\Models\TypeReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

    /** @test */
    public function should_return_people_for_report_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->peopleForReport->byIds([]));
    }

    /** @test */
    public function should_return_people_for_report_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->peopleForReport->byUserIds([]));
    }

    /** @test */
    public function should_return_people_for_report_by_type_report_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->peopleForReport->byTypeReportIds([]));
    }

}
