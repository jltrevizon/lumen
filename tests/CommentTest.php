<?php

use App\Models\Comment;
use App\Models\Damage;
use App\Models\DamageImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function it_belongs_to_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->damage());
        $this->assertInstanceOf(Damage::class, $this->comment->damage()->getModel());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->user());
        $this->assertInstanceOf(User::class, $this->comment->user()->getModel());
    }

    /** @test */
    public function it_has_many_damage_images()
    {
        $this->assertInstanceOf(HasMany::class, $this->comment->damageImages());
        $this->assertInstanceOf(DamageImage::class, $this->comment->damageImages()->getModel());
    }

    /** @test */
    public function should_return_comments_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byUserIds([]));
    }

    /** @test */
    public function should_return_comments_by_damage_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byDamageIds([]));
    }

    /** @test */
    public function should_return_comments_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->comment->byUserIds([]));
    }

}
