<?php

use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PasswordResetCodeTest extends TestCase
{

    use DatabaseTransactions;

    private PasswordResetCode $passwordResetCode;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passwordResetCode = PasswordResetCode::factory()->create();
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->passwordResetCode->user());
        $this->assertInstanceOf(User::class, $this->passwordResetCode->user()->getModel());
    }

    /** @test */
    public function should_return_password_reset_code_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->passwordResetCode->byIds([]));
    }

    /** @test */
    public function should_return_password_reset_code_by_user_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->passwordResetCode->byUserIds([]));
    }

    /** @test */
    public function should_return_password_reset_code_active()
    {
        $this->assertInstanceOf(Builder::class, $this->passwordResetCode->byActive(1));
    }

}
