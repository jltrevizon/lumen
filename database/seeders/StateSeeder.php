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
            [ 'name' => 'En campa'],
            [ 'name' => 'Reservado' ],
            [ 'name' => 'Defletado' ],
            [ 'name' => 'Taller' ],
            [ 'name' => 'Disponible' ],
            [ 'name' => 'Pre-Disponible' ],
            [ 'name' => 'Pendiente Venta V.O.' ],
            [ 'name' => 'Pendiente Recoger Cliente' ],
            [ 'name' => 'En tránsito' ],
            [ 'name' => 'Reservado Pre-Entrega' ],
            [ 'name' => 'Entregado']
        ];
    }
}
