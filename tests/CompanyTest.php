<?php

use App\Models\Campa;
use App\Models\Company;
use App\Models\Customer;
use App\Models\DefleetVariable;
use App\Models\Question;
use App\Models\ReservationTime;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{

    use DatabaseTransactions;

    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
    }

    /** @test */
    public function it_has_many_to_campas()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->campas());
        $this->assertInstanceOf(Campa::class, $this->company->campas()->getModel());
    }

    /** @test */
    public function it_has_many_reservation_time()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->reservationTimes());
        $this->assertInstanceOf(ReservationTime::class, $this->company->reservationTimes()->getModel());
    }

    /** @test */
    public function it_has_many_to_customers()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->customers());
        $this->assertInstanceOf(Customer::class, $this->company->customers()->getModel());
    }

    /** @test */
    public function it_has_many_to_users()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->users());
        $this->assertInstanceOf(User::class, $this->company->users()->getModel());
    }


    /** @test */
    public function it_has_many_to_questions()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->questions());
        $this->assertInstanceOf(Question::class, $this->company->questions()->getModel());
    }

    /** @test */
    public function it_has_one_to_defleet_variable()
    {
        $this->assertInstanceOf(HasOne::class, $this->company->defleetVariable());
        $this->assertInstanceOf(DefleetVariable::class, $this->company->defleetVariable()->getModel());
    }


    /** @test */
    public function it_has_many_to_states()
    {
        $this->assertInstanceOf(HasMany::class, $this->company->states());
        $this->assertInstanceOf(State::class, $this->company->states()->getModel());
    }

    /** @test */
    public function should_return_companies_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->company->byIds([]));
    }

    /** @test */
    public function should_return_companies_by_name()
    {
        $this->assertInstanceOf(Builder::class, $this->company->byName(''));
    }

    /** @test */   
    public function should_return_companies_by_nif()
    {
        $this->assertInstanceOf(Builder::class, $this->company->byNif(''));
    }

    /** @test */
    public function should_return_companies_by_phone()
    {
        $this->assertInstanceOf(Builder::class, $this->company->byPhone(0));
    }
}
