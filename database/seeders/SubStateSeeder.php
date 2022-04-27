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
                'state_id' => $subState['state_id'],
                'display_name' => $subState['display_name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Campa',
                'state_id' => State::AVAILABLE,
                'display_name' => 'Campa'
            ],
            [
                'name' => 'Pendiente Lavado',
                'state_id' => State::AVAILABLE,
                'display_name' => 'Pendiente lavado'
            ],
            [
                'name' => 'Mecánica',
                'state_id' => State::WORKSHOP,
                'display_name' => 'Mecánica'
            ],
            [
                'name' => 'Chapa',
                'state_id' => State::WORKSHOP,
                'display_name' => 'Chapa'
            ],
            [
                'name' => 'Transformación',
                'state_id' => State::WORKSHOP,
                'display_name' => 'Transformación'
            ],
            [
                'name' => 'ITV',
                'state_id' => State::WORKSHOP,
                'display_name' => 'ITV'
            ],
            [
                'name' => 'Limpieza',
                'state_id' => State::WORKSHOP,
                'display_name' => 'Limpieza'
            ],
            [
                'name' => 'Solicitado defleet',
                'state_id' => State::PENDING_SALE_VO,
                'display_name' => 'Defleet'
            ],
            [
                'name' => 'Sin documentación',
                'state_id' => State::NOT_AVAILABLE,
                'display_name' => 'Estado sin documentación'
            ],
            [
                'name' => 'Alquilado',
                'state_id' => State::DELIVERED,
                'display_name' => 'En alquiler'
            ],
            [
                'name' => 'Check',
                'state_id' => State::PRE_AVAILABLE,
                'display_name' => 'En check'
            ],
            [
                'name' => 'No disponible',
                'state_id' => State::NOT_AVAILABLE,
                'display_name' => 'Estado no disponible'
            ]
        ];
    }
}
