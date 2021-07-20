<?php

use App\Models\PendingTask;
use App\Models\PendingTaskCanceled;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PendingTaskCanceledTest extends TestCase
{

    use DatabaseTransactions;

   private PendingTaskCanceled $pendingTaskCanceled;

   protected function setUp(): void
   {
       parent::setUp();
       $this->pendingTaskCanceled = PendingTaskCanceled::factory()->create();
   }

   /** @test */
   public function it_belongs_to_pending_task()
   {
       $this->assertInstanceOf(BelongsTo::class, $this->pendingTaskCanceled->pendingTask());
       $this->assertInstanceOf(PendingTask::class, $this->pendingTaskCanceled->pendingTask()->getModel());
   }
}
