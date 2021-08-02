<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use App\Models\SubState;

class SubStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subStates = $this->data();
        foreach($subStates as $subState){
            SubState::create([
                'name' => $subState['name'],
                'state_id' => $subState['state_id']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Campa',
                'state_id' => State::AVAILABLE,
            ],
            [
                'name' => 'Pendiente Lavado',
                'state_id' => State::AVAILABLE,
            ],
            [
                'name' => 'Mecánica',
                'state_id' => State::WORKSHOP,
            ],
            [
                'name' => 'Chapa',
                'state_id' => State::WORKSHOP,
            ],
            [
                'name' => 'Transformación',
                'state_id' => State::WORKSHOP,
            ],
            [
                'name' => 'ITV',
                'state_id' => State::WORKSHOP,
            ],
            [
                'name' => 'Limpieza',
                'state_id' => State::WORKSHOP,
            ],
            [
                'name' => 'Solicitado defleet',
                'state_id' => State::PENDING_SALE_VO,
            ],
            [
                'name' => 'Sin documentación',
                'state_id' => State::NOT_AVAILABLE,
            ],
            [
                'name' => 'Alquilado',
                'state_id' => State::DELIVERED
            ],
            [
                'name' => 'Check',
                'state_id' => State::PRE_AVAILABLE
            ],
            [
                'name' => 'No disponible',
                'state_id' => State::NOT_AVAILABLE
            ]
        ];
    }
}
