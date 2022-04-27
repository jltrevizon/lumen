<?php

namespace Database\Seeders;

use App\Models\TypeDeliveryNote;
use Illuminate\Database\Seeder;

class TypeDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = $this->data();
        foreach ($types as $type) {
            TypeDeliveryNote::create([
                'description' => $type['description']
            ]);
        }
    }

    private function data(){
        return [
            ['description' => 'Entrega de vehículos'],
            ['description' => 'Traslado de vehículos']
        ];
    }
}
