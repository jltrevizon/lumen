<?php

use App\Models\Budget;
use App\Models\BudgetLine;
use App\Models\Tax;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetLineFilterTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        BudgetLine::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $budgetLine = BudgetLine::factory()->create();
        $data = BudgetLine::filter(['ids' => [$budgetLine->id]])->get();
        $this->assertCount(1, $data);
    }

    /** @test */
    public function it_can_filter_by_budget_ids()
    {
        $budget = Budget::factory()->create();
        $budgetLine = BudgetLine::factory()->create(['budget_id' => $budget->id]);
        $data = BudgetLine::filter(['budget_ids' => [$budget->id]])->get();
        $this->assertCount(1, $data);
        $this->assertEquals($data[0]->id, $budgetLine->id);
    }

    /** @test */
    public function it_can_filter_by_tax_ids()
    {
        $tax1 = Tax::factory()->create([
            'name' => '21%',
            'value' => 21,
            'description' => 'IVA general'
        ]);
        $tax2 = Tax::factory()->create([
            'name' => '10%',
            'value' => 10,
            'description' => 'IVA reducido'
        ]);
        BudgetLine::query()->update(['tax_id' => $tax2->id]);
        $budgetLine = BudgetLine::factory()->create(['tax_id' => $tax1->id]);
        $budgetLines = BudgetLine::filter(['tax_ids' => [$tax1->id]])->get();
        $this->assertCount(1, $budgetLines);
        $this->assertEquals($budgetLines[0]->id, $budgetLine->id);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        BudgetLine::query()->update(['name' => 'Budget Line test']);
        $budgetLine = BudgetLine::factory()->create();
        $budgetLines = BudgetLine::filter(['name' => $budgetLine->name])->get();
        $this->assertCount(1, $budgetLines);
        $this->assertEquals($budgetLines[0]->id, $budgetLine->id);
    }

}
