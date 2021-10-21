<?php

use App\Models\Comment;
use App\Models\Incidence;
use App\Models\IncidenceImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncidenceImageTest extends TestCase
{

    use DatabaseTransactions;

    private IncidenceImage $incidenceImage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->incidenceImage = IncidenceImage::factory()->create();
    }

    /** @test */
    public function it_belongs_to_incidence()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->incidenceImage->incidence());
        $this->assertInstanceOf(Incidence::class, $this->incidenceImage->incidence()->getModel());
    }

    /** @test */
    public function it_belongs_to_comment()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->incidenceImage->comment());
        $this->assertInstanceOf(Comment::class, $this->incidenceImage->comment()->getModel());
    }

    /** @test */
    public function should_return_incidence_images_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->incidenceImage->byIds([]));
    }

    /** @test */
    public function should_return_incidence_images_by_incidence_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->incidenceImage->byIncidenceIds([]));
    }

    /** @test */
    public function should_return_incidence_images_by_comment_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->incidenceImage->byCommentIds([]));
    }

}
