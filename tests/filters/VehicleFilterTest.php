<?php

use App\Models\Vehicle;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Vehicle::factory()->count(3)->create();
    }

    /** @test */
    public function it_can_filter_vehicles_by_created_at()
    {
        Vehicle::query()->update(['created_at' => Carbon::now()->subDays(2)]);
        $vehicle = Vehicle::factory()->create();
        $data = Vehicle::filter(['created_at' => [$vehicle->created_at]])->get();
        $this->assertCount(1, $data);
    }

}
