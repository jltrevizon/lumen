<?php

use App\Models\BudgetLine;
use App\Models\TypeBudgetLine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeBudgetLineTest extends TestCase
{

    use DatabaseTransactions;

    private TypeBudgetLine $typeBudgetLine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeBudgetLine = TypeBudgetLine::factory()->create();
    }

    /** @test */
    public function it_has_many_budget_lines(){
        $this->assertInstanceOf(HasMany::class, $this->typeBudgetLine->budgetLines());
        $this->assertInstanceOf(BudgetLine::class, $this->typeBudgetLine->budgetLines()->getModel());
    }

}
