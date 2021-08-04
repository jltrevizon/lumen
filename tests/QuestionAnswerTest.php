<?php

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Questionnaire;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuestionAnswerTest extends TestCase
{

    use DatabaseTransactions;

    private QuestionAnswer $questionAnswer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionAnswer = QuestionAnswer::factory()->create();
    }

    /** @test */
    public function it_belongs_to_questionnaire()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->questionAnswer->questionnaire());
        $this->assertInstanceOf(Questionnaire::class, $this->questionAnswer->questionnaire()->getModel());
    }

    /** @test */
    public function it_belongs_to_question()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->questionAnswer->question());
        $this->assertInstanceOf(Question::class, $this->questionAnswer->question()->getModel());
    }

    /** @test */
    public function it_belongs_to_task()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->questionAnswer->task());
        $this->assertInstanceOf(Task::class, $this->questionAnswer->task()->getModel());
    }
}
