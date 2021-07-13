<?php

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_belongs_to_a_role()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->user->role());
        $this->assertInstanceOf(Role::class, $this->user->role->getModel());
    }

    /** @test */
    public function it_belongs_to_a_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->user->company());
        $this->assertInstanceOf(Company::class, $this->user->company->getModel());
    }
}
