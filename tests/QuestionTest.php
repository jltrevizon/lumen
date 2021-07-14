<?php

use App\Models\Company;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuestionTest extends TestCase
{
    private Question $question;

    protected function setUp(): void
    {
        parent::setUp();
        $this->question = Question::factory()->create();
    }

    /** @test */
    public function it_belongs_to_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->question->company());
        $this->assertInstanceOf(Company::class, $this->question->company()->getModel());
    }

    /** @test */
    public function it_has_many_question_answer()
    {
        $this->assertInstanceOf(HasMany::class, $this->question->question_answer());
        $this->assertInstanceOf(QuestionAnswer::class, $this->question->question_answer()->getModel());
    }
}
