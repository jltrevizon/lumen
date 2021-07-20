<?php

use App\Models\SubState;
use App\Models\TypeUserApp;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeUserAppTest extends TestCase
{

    use DatabaseTransactions;

    private TypeUserApp $typeUserApp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeUserApp = TypeUserApp::factory()->create();
    }

    /** @test */
    public function it_belongs_to_many_sub_states()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->typeUserApp->sub_states());
        $this->assertInstanceOf(SubState::class, $this->typeUserApp->sub_states()->getModel());
    }

    /** @test */
    public function it_has_many_users()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeUserApp->users());
        $this->assertInstanceOf(User::class, $this->typeUserApp->users()->getModel());
    }
}
