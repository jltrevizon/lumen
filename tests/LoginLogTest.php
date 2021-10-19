<?php

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginLogTest extends TestCase
{
   
    use DatabaseTransactions;

    private loginLog $loginLog;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginLog = LoginLog::factory()->create();
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->loginLog->user());
        $this->assertInstanceOf(User::class, $this->loginLog->user()->getModel());
    }

    /** @test */
    public function should_return_login_logs_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->loginLog->byIds([]));
    }

    /** @test */
    public function should_return_login_logs_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->loginLog->byUserIds([]));
    }
}
