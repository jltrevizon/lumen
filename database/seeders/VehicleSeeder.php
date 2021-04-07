<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = $this->data();
        foreach($vehicles as $vehicle){
            Vehicle::create([
                'campa_id' => $vehicle['campa_id'],
                'category_id' => $vehicle['category_id'],
                'ubication' => $vehicle['ubication'],
                'plate' => $vehicle['plate'],
                'branch' => $vehicle['branch'],
                'vehicle_model' => $vehicle['vehicle_model'],
                'first_plate' => $vehicle['first_plate'],

            ]);
        }
    }

    public function data(){
        return [
            [
                'campa_id' => 1,
                'category_id' => 1,
                'ubication' => 'G15',
                'plate' => '3426GZZ',
                'branch' => 'Seat',
                'vehicle_model' => 'León',
                'first_plate' => '2000-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 3,
                'ubication' => 'G16',
                'plate' => '4132HRT',
                'branch' => 'Mini',
                'vehicle_model' => 'Cooper',
                'first_plate' => '1995-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 5,
                'ubication' => 'G17',
                'plate' => '6037BBB',
                'branch' => 'Seat',
                'vehicle_model' => 'Ibiza',
                'first_plate' => '1999-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 7,
                'ubication' => 'G18',
                'plate' => '7547BBB',
                'branch' => 'Renault',
                'vehicle_model' => 'Megane',
                'first_plate' => '1998-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 4,
                'ubication' => 'G25',
                'plate' => '8181CLB',
                'branch' => 'Nissan',
                'vehicle_model' => 'Micra',
                'first_plate' => '2001-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 8,
                'ubication' => 'G21',
                'plate' => '8256RTS',
                'branch' => 'BMW',
                'vehicle_model' => 'Serie 1',
                'first_plate' => '2002-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 6,
                'ubication' => 'G37',
                'plate' => '6358GHN',
                'branch' => 'Fiat',
                'vehicle_model' => '500',
                'first_plate' => '2003-05-21'
            ],
            [
                'campa_id' => 1,
                'category_id' => 2,
                'ubication' => 'G35',
                'plate' => '6984YND',
                'branch' => 'Volkswagen',
                'vehicle_model' => 'Polo',
                'first_plate' => '2005-05-21'
            ],
        ];
    }
}
