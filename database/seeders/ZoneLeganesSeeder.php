<?php

namespace Database\Seeders;

use App\Models\Campa;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneLeganesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zones = $this->data();
        foreach($zones as $zone){
            Zone::create([
                'campa_id' => $zone['campa_id'],
                'name' => $zone['name']
            ]);
        }
    }

    private function data(){
        return [
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Recepción'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Nave Recepción'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Taller'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Lavadero'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Ubicación'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => '2D'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Entregas'
            ],
            [
                'campa_id' => Campa::LEGANES,
                'name' => 'Photocall'
            ],
        ];
    }
}
