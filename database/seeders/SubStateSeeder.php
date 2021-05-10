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
                'name' => 'Campa',
                'state_id' => 1,
            ],
            [
                'name' => 'Pendiente Lavado',
                'state_id' => 1,
            ],
            [
                'name' => 'Mecánica',
                'state_id' => 2,
            ],
            [
                'name' => 'Chapa',
                'state_id' => 2,
            ],
            [
                'name' => 'Transformación',
                'state_id' => 2,
            ],
            [
                'name' => 'ITV',
                'state_id' => 2,
            ],
            [
                'name' => 'Limpieza',
                'state_id' => 2,
            ],
            [
                'name' => 'Solicitado defleet',
                'state_id' => 3,
            ],
            [
                'name' => 'Sin documentación',
                'state_id' => 4,
            ],
        ];
    }
}
