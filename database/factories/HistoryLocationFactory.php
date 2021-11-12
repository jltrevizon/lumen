<?php

namespace Database\Factories;

use App\Model;
use App\Models\HistoryLocation;
use App\Models\Square;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryLocationFactory extends Factory
{
    protected $model = HistoryLocation::class;

    public function definition(): array
    {
    	return [
    	    'vehicle_id' => Vehicle::factory()->create()->id,
            'square_id' => Square::factory()->create()->id
    	];
    }
}
