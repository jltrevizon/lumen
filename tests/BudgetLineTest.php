<?php

use App\Models\Budget;
use App\Models\BudgetLine;
use App\Models\Tax;
use App\Models\TypeBudgetLine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetLineTest extends TestCase
{

    use DatabaseTransactions;

    private BudgetLine $budgetLine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->budgetLine = BudgetLine::factory()->create();
    }

    /** @test */
    public function it_belongs_to_budget()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetLine->budget());
        $this->assertInstanceOf(Budget::class, $this->budgetLine->budget()->getModel());
    }

    /** @test */
    public function it_belongs_to_type_budget_line()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetLine->typeBudgetLine());
        $this->assertInstanceOf(TypeBudgetLine::class, $this->budgetLine->typeBudgetLine()->getModel());
    }

    /** @test */
    public function it_belongs_to_type_tax()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->budgetLine->tax());
        $this->assertInstanceOf(Tax::class, $this->budgetLine->tax()->getModel());
    }

    /** @test */
    public function should_return_budget_lines_by_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetLine->byIds([]));
    }

    /** @test */
    public function should_return_budget_lines_by_budget_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetLine->byBudgetIds([]));
    }

    /** @test */
    public function should_return_budget_lines_by_tax_ids()
    {
        $this->assertInstanceOf(Builder::class, $this->budgetLine->byTaxIds([]));
    }

    /** @test */
    public function should_return_budget_lines_by_name(){
        $this->assertInstanceOf(Builder::class, $this->budgetLine->byName(''));
    }
}
