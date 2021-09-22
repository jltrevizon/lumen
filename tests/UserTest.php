<?php

use App\Models\Campa;
use App\Models\Company;
use App\Models\PeopleForReport;
use App\Models\Role;
use App\Models\TypeUserApp;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

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

    /** @test */
    public function it_belongs_to_many_a_campas()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->user->campas());
        $this->assertInstanceOf(Campa::class, $this->user->campas()->getModel());
    }

    /** @test */
    public function it_belongs_to_type_user_app()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->user->type_user_app());
        $this->assertInstanceOf(TypeUserApp::class, $this->user->type_user_app()->getModel());
    }

    /** @test */
    public function it_has_many_people_for_reports()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->peopleForReports());
        $this->assertInstanceOf(PeopleForReport::class, $this->user->peopleForReports()->getModel());
    }
}
