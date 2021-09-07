<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\SubState;
use Illuminate\Database\Seeder;

class SubState2Seeder extends Seeder
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
                'name' => 'Taller externo',
                'state_id' => State::WORKSHOP
            ],
            [
                'name' => 'Pre-disponible',
                'state_id' => State::PRE_AVAILABLE
            ]
        ];
    }
}
