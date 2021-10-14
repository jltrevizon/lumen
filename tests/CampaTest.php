<?php

use App\Models\Campa;
use App\Models\Company;
use App\Models\Province;
use App\Models\Reception;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CampaTest extends TestCase
{

    use DatabaseTransactions;

    private Campa $campa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->campa = Campa::factory()->create();
    }

    /** @test */
    public function it_belongs_to_many_users()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->campa->users());
        $this->assertInstanceOf(User::class, $this->campa->users()->getModel());
    }

    /** @test */
    public function it_belongs_to_province()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->campa->province());
        $this->assertInstanceOf(Province::class, $this->campa->province()->getModel());
    }

    /** @test */
    public function it_belongs_to_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->campa->company());
        $this->assertInstanceOf(Company::class, $this->campa->company()->getModel());
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->campa->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->campa->vehicles()->getModel());
    }

    /** @test */
    public function it_has_many_reservations()
    {
        $this->assertInstanceOf(HasMany::class, $this->campa->reservations());
        $this->assertInstanceOf(Reservation::class, $this->campa->reservations()->getModel());
    }

    /** @test */
    public function it_has_many_receptions()
    {
        $this->assertInstanceOf(HasMany::class, $this->campa->receptions());
        $this->assertInstanceOf(Reception::class, $this->campa->receptions()->getModel());
    }

    /** @test */
    public function search_by_company()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byCompany(1));
    }

    /** @test */
    public function search_by_companies()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byCompanies([]));
    }

    /** @test */
    public function search_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byIds([]));
    }

    /** @test */
    public function should_return_campas_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byName(''));
    }

    /** @test */
    public function search_by_province()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byProvince(1));
    }

    /** @test */
    public function search_by_provinces()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byProvinces([]));
    }

    /** @test */
    public function search_by_region()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byRegion(1));
    }

    /** @test */
    public function search_by_regions()
    {
        $this->assertInstanceOf(Builder::class, $this->campa->byRegions([]));
    }
}
