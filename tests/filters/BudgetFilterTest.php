<?php

use App\Filters\BudgetFilter;
use App\Models\Budget;
use App\Models\Vehicle;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BudgetFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Budget::factory()->count(3)->create();
    }

    /** @test */
    public function it_can_filter_by_vehicle_ids()
    {
        $vehicle1 = Vehicle::factory()->create();
        $vehicle2 = Vehicle::factory()->create();
        Budget::query()->update(['vehicle_id' => $vehicle1->id]);
        Budget::factory()->create(['vehicle_id' => $vehicle2->id]);
        $data = Budget::filter(['vehicle_ids' => [$vehicle2->id]])->get();
        $this->assertCount(1, $data);
    }

}
