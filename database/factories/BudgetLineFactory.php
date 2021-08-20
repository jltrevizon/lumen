<?php

namespace Database\Factories;

use App\Model;
use App\Models\Budget;
use App\Models\BudgetLine;
use App\Models\Tax;
use App\Models\TypeBudgetLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetLineFactory extends Factory
{
    protected $model = BudgetLine::class;

    public function definition(): array
    {
    	return [
    	    'budget_id' => Budget::factory()->create()->id,
            'type_budget_line_id' => TypeBudgetLine::factory()->create()->id,
            'tax_id' => Tax::factory()->create()->id,
            'name' => $this->faker->name,
            'sub_total' => $this->faker->randomFloat(2, 0, 1000),
            'tax' => $this->faker->randomFloat(2, 0, 1000),
            'total' => $this->faker->randomFloat(2, 0, 1000)
    	];
    }
}
