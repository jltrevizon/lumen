<?php

namespace Database\Seeders;

use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RepairTypeModelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::debug('REPARAR LOS CANALES NULOS');
        $vehicles = Vehicle::whereNull('deleted_at')->get();
        foreach ($vehicles as $key => $vehicle) {
            if ($vehicle->type_model_order_id && $vehicle->lastReception) {
                Log::debug($vehicle->id);
                Reception::whereNull('type_model_order_id')
                ->where('vehicle_id', $vehicle->id)
                ->update([
                    'type_model_order_id' => $vehicle->type_model_order_id
                ]);
            }
        }
    }
}
