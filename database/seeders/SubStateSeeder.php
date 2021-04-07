<?php

namespace Database\Seeders;

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
                'name' => 'Campa (Disponible)',
                'state_id' => 5,
            ],
            [
                'name' => 'Pendiente Lavado',
                'state_id' => 5,
            ],
            [
                'name' => 'Mecánica',
                'state_id' => 4,
            ],
            [
                'name' => 'Chapa',
                'state_id' => 4,
            ],
            [
                'name' => 'ITV',
                'state_id' => 4,
            ],
            [
                'name' => 'Finalizado',
                'state_id' => 4,
            ],
            [
                'name' => 'Transformación',
                'state_id' => 4,
            ],
            [
                'name' => 'Limpieza',
                'state_id' => 4,
            ],
            [
                'name' => 'Campa (Reservado)',
                'state_id' => 2,
            ],
            [
                'name' => 'Check',
                'state_id' => 6,
            ],
            [
                'name' => 'Distintivo',
                'state_id' => 6,
            ],
            [
                'name' => 'Campa (Pre-Disponible)',
                'state_id' => 6,
            ],
            [
                'name' => 'Otras ubicaciones',
                'state_id' => 6,
            ],
            [
                'name' => 'Valoración',
                'state_id' => 7,
            ],
            [
                'name' => 'Estudio',
                'state_id' => 7,
            ],
            [
                'name' => 'Venta V.O.',
                'state_id' => 7,
            ],
            [
                'name' => 'En Cliente',
                'state_id' => 8,
            ],
            [
                'name' => 'Transporte',
                'state_id' => 9,
            ],
            [
                'name' => 'Depósito',
                'state_id' => 9,
            ],
            [
                'name' => 'Campa (Reservado Pre-Entrega)',
                'state_id' => 10,
            ],

        ];
    }
}
