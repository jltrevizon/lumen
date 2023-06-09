<?php

use App\Models\Company;
use App\Models\DefleetVariable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DefleetVariableTest extends TestCase
{

    use DatabaseTransactions;

    private DefleetVariable $defleetVariable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defleetVariable = DefleetVariable::factory()->create();
    }

    /** @test */
    public function it_belongs_to_company()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->defleetVariable->company());
        $this->assertInstanceOf(Company::class, $this->defleetVariable->company()->getModel());
    }

    /** @test */
    public function search_by_company()
    {
        $this->assertInstanceOf(Builder::class, $this->defleetVariable->byCompany(1));
    }

}
