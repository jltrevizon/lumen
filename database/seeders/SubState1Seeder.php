<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\SubState;
use Illuminate\Database\Seeder;

class SubState1Seeder extends Seeder
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
                'name' => 'Pendiente prueba dinámica',
                'state_id' => State::PENDING_TEST_DINAMIC
            ],
            [
                'name' => 'Pendiente checklist incial',
                'state_id' => State::PENDING_INITIAL_CHECK
            ],
            [
                'name' => 'Pendiente de presupuesto',
                'state_id' => State::PENDING_BUDGET
            ],
            [
                'name' => 'Pendiente de autorización',
                'state_id' => State::PENDING_AUTHORIZATION
            ],
            [
                'name' => 'En reparación',
                'state_id' => State::IN_REPAIR
            ],
            [
                'name' => 'Pendiente de certificado',
                'state_id' => State::PENDING_CERTIFICATED
            ],
            [
                'name' => 'Pendiente de check final',
                'state_id' => State::PENDING_FINAL_CHECK
            ]
        ];
    }
}
