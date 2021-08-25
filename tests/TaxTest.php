<?php

use App\Models\BudgetLine;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TaxTest extends TestCase
{

    use DatabaseTransactions;

    private Tax $tax;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tax = Tax::factory()->create();
    }

    /** @test */
    public function it_has_many_budget_lines()
    {
        $this->assertInstanceOf(HasMany::class, $this->tax->budgetLines());
        $this->assertInstanceOf(BudgetLine::class, $this->tax->budgetLines()->getModel());
    }
}
