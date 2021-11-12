<?php

use App\Models\GroupTask;
use App\Models\QuestionAnswer;
use App\Models\Questionnaire;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuestionnaireTest extends TestCase
{

    use DatabaseTransactions;

    private Questionnaire $questionnaire;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionnaire = Questionnaire::factory()->create();
    }

    /** @test */
    public function it_belongs_to_vehicle()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->questionnaire->vehicle());
        $this->assertInstanceOf(Vehicle::class, $this->questionnaire->vehicle()->getModel());
    }

    /** @test */
    public function it_has_many_question_answer()
    {
        $this->assertInstanceOf(HasMany::class, $this->questionnaire->questionAnswers());
        $this->assertInstanceOf(QuestionAnswer::class, $this->questionnaire->questionAnswers()->getModel());
    }

    /** @test */
    public function it_has_one_group_task()
    {
        $this->assertInstanceOf(HasOne::class, $this->questionnaire->groupTask());
        $this->assertInstanceOf(GroupTask::class, $this->questionnaire->groupTask()->getModel());
    }
}
