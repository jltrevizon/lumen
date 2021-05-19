<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeReservation;

class TypeReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = $this->data();
        foreach($types as $type){
            TypeReservation::create([
                'description' => $type['description']
            ]);
        }
    }

    public function data(){
        return [
            ['description' => 'Normal'],
            ['description' => 'Pre-entrega']
        ];
    }
}
