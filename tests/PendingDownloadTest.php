<?php

use App\Models\PendingDownload;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingDownloadTest extends TestCase
{
    use DatabaseTransactions;

    private PendingDownload $pendingDownload;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pendingDownload = PendingDownload::factory()->create();
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pendingDownload->user());
        $this->assertInstanceOf(User::class, $this->pendingDownload->user()->getModel());
    }
}
