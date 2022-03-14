<?php

use App\Models\Comment;
use App\Models\Damage;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CommentFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Comment::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $comment = Comment::factory()->create();
        $comments = Comment::filter(['ids' => [$comment->id]])->get();
        $this->assertCount(1, $comments);
    }

    /** @test */
    public function it_can_filter_by_damages()
    {
        $damage1 = Damage::factory()->create();
        $damage2 = Damage::factory()->create();
        Comment::query()->update(['damage_id' => $damage1->id]);
        Comment::factory()->create(['damage_id' => $damage2->id]);
        $comments = Comment::filter(['damage_ids' => [$damage2->id]])->get();
        $this->assertCount(1, $comments);
    }

    /** @test */
    public function it_can_filter_by_user_ids()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Comment::query()->update(['user_id' => $user1->id]);
        Comment::factory()->create(['user_id' => $user2->id]);
        $comments = Comment::filter(['user_ids' => [$user2->id]])->get();
        $this->assertCount(1, $comments);
    }

}
