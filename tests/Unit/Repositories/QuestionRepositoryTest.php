<?php

use App\Models\Question;
use App\Models\User;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuestionRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new QuestionRepository();
    }

    /** @test */
    public function it_can_create_a_question_correctly()
    {
        $question = '¿Question 1?';
        $description = '¿Question 1?';
        $user = User::factory()->create();
        $this->actingAs($user);
        $request = new Request();
        $request->replace(['question' => $question, 'description' => $description]);
        $result = $this->repository->create($request);
        $this->assertEquals($question, $result['question']);
        $this->assertEquals($description, $result['description']);
        $this->assertInstanceOf(Question::class, $result);
    }

    /** @test */
    public function should_return_two_questions()
    {
        $user = User::factory()->create();
        Question::factory()->create(['company_id' => $user->company_id]);
        Question::factory()->create(['company_id' => $user->company_id]);
        $this->actingAs($user);
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result);
    }

    /** @test */
    public function should_return_two_questions_by_filter()
    {
        Question::factory()->create();
        Question::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->filter($request);
        $this->assertCount(2, $result->items());
    }

}
