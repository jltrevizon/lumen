<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = $this->data();
        foreach($states as $state){
            State::create([
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Disponible',
                'company_id' => 1
            ],
            [
                'name' => 'Taller',
                'company_id' => 1
            ],
            [
                'name' => 'Pendiente Venta V.O.',
                'company_id' => 1
            ],
            [
                'name' => 'No disponible',
                'company_id' => 1
            ],
            [
                'name' => 'Entregado',
                'company_id' => 1
            ],
            [
                'name' => 'Pre-disponible',
                'company_id' => 1
            ]
        ];
    }
}
