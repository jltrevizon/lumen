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
            [ 'name' => 'Disponible'],
            [ 'name' => 'Taller' ],
            [ 'name' => 'Pendiente Venta V.O.' ],
            [ 'name' => 'No disponible' ],
            [ 'name' => 'Entregado' ]
        ];
    }
}
