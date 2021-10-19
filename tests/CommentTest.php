<?php

use App\Models\Comment;
use App\Models\Incidence;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->comment = Comment::factory()->create();
    }

    /** @test */
    public function it_belongs_to_incidence()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->incidence());
        $this->assertInstanceOf(Incidence::class, $this->comment->incidence()->getModel());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->user());
        $this->assertInstanceOf(User::class, $this->comment->user()->getModel());
    }

    /** @test */
    public function should_return_comments_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byUserIds([]));
    }

    /** @test */
    public function should_return_comments_by_incidence_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byIncidenceIds([]));
    }

    /** @test */
    public function should_return_comments_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byUserIds([]));
    }

}
