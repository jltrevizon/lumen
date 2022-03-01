<?php

use App\Models\Damage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
    }

    /** @test */
    public function it_has_many_users()
    {
        $this->assertInstanceOf(HasMany::class, $this->role->users());
        $this->assertInstanceOf(User::class, $this->role->users()->getModel());
    }

    /** test */
    public function it_belongs_to_many_damages()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->role->damages());
        $this->assertInstanceOf(Damage::class, $this->role->damages()->getModel());
    }
}
