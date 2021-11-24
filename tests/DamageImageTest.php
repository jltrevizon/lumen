<?php

use App\Models\Comment;
use App\Models\Damage;
use App\Models\DamageImage;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DamageImageTest extends TestCase
{
    
    use DatabaseTransactions;

    private DamageImage $damageImage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->damageImage = DamageImage::factory()->create();
    }

    /** @test */
    public function it_belongs_to_damage()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damageImage->damage());
        $this->assertInstanceOf(Damage::class, $this->damageImage->damage()->getModel());
    }

    /** @test */
    public function it_belongs_to_comment()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->damageImage->comment());
        $this->assertInstanceOf(Comment::class, $this->damageImage->comment()->getModel());
    }

    /** @test */
    public function should_return_damage_images_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byIds([]));
    }


    /** @test */
    public function should_return_damage_images_by_damage_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->damageImage->byDamageIds([]));
    }

}
