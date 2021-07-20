<?php

use App\Models\PasswordResetCode;
use App\Models\User;
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
}
