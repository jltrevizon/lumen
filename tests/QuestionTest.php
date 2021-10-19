<?php

use App\Models\Company;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuestionTest extends TestCase
{

    use DatabaseTransactions;

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

    /** @test */
    public function should_return_questions_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->question->byIds([]));
    }

    /** @test */
    public function should_return_questions_by_company_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->question->byCompanyIds([]));
    }

    /** @test */
    public function should_return_questions_by_name_question()
    {
        $this->assertInstanceOf(Builder::class, $this->question->byNameQuestion(''));
    }
}
