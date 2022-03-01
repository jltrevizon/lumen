<?php

namespace Database\Seeders;

use App\Models\Street;
use Illuminate\Database\Seeder;

class StreetLeganesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $streets = $this->data();
        foreach($streets as $street){
            Street::create([
                'zone_id' => $street['zone_id'],
                'name' => $street['name']
            ]);
        }
    }

    private function data(){
        return [
            [
                'zone_id' => 1,
                'name' => 'RC'
            ],
            [
                'zone_id' => 2,
                'name' => 'NRZ'
            ],
            [
                'zone_id' => 2,
                'name' => 'O'
            ],
            [
                'zone_id' => 2,
                'name' => 'P'
            ],
            [
                'zone_id' => 2,
                'name' => 'Q'
            ],
            [
                'zone_id' => 3,
                'name' => 'U'
            ],
            [
                'zone_id' => 3,
                'name' => 'V'
            ],
            [
                'zone_id' => 3,
                'name' => 'W'
            ],
            [
                'zone_id' => 3,
                'name' => 'X'
            ],
            [
                'zone_id' => 3,
                'name' => 'Y'
            ],
            [
                'zone_id' => 4,
                'name' => 'A'
            ],
            [
                'zone_id' => 4,
                'name' => 'B'
            ],
            [
                'zone_id' => 4,
                'name' => 'C'
            ],
            [
                'zone_id' => 4,
                'name' => 'D'
            ],
            [
                'zone_id' => 4,
                'name' => 'E'
            ],
            [
                'zone_id' => 4,
                'name' => 'F'
            ],
            [
                'zone_id' => 4,
                'name' => 'G'
            ],
            [
                'zone_id' => 4,
                'name' => 'H'
            ],
            [
                'zone_id' => 4,
                'name' => 'I'
            ],
            [
                'zone_id' => 4,
                'name' => 'J'
            ],
            [
                'zone_id' => 4,
                'name' => 'K'
            ],
            [
                'zone_id' => 4,
                'name' => 'L'
            ],
            [
                'zone_id' => 4,
                'name' => 'M'
            ],
            [
                'zone_id' => 4,
                'name' => 'N'
            ],
            [
                'zone_id' => 4,
                'name' => 'R'
            ],
            [
                'zone_id' => 4,
                'name' => 'S'
            ],
            [
                'zone_id' => 4,
                'name' => 'T'
            ],
            [
                'zone_id' => 4,
                'name' => 'Z'
            ],
            [
                'zone_id' => 4,
                'name' => 'ZZ'
            ],
            [
                'zone_id' => 4,
                'name' => 'ELEC'
            ],
            [
                'zone_id' => 5,
                'name' => '2D'
            ],
            [
                'zone_id' => 5,
                'name' => 'Entrega'
            ],
            [
                'zone_id' => 5,
                'name' => 'Photocall'
            ],
        ];
    }
}
