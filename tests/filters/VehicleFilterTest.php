<?php

use App\Models\Vehicle;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Vehicle::factory(3)->create();
    }


    public function it_can_filter_vehicles_by_created_at()
    {
        Vehicle::query()->update(['created_at' => Carbon::now()->subDays(2)]);
        $vehicle = Vehicle::factory()->create();
        $data = Vehicle::filter(['created_at' => [$vehicle->created_at]])->get();
        $this->assertCount(1, $data);
    }

}
