<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TradeState;

class TradeStateSeeder extends Seeder
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
            TradeState::create([
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Disponible' ],
            [ 'name' => 'Reservado'],
            [ 'name' => 'Defletado'],
            [ 'name' => 'Entregado' ],
            [ 'name' => 'No disponible' ]
        ];
    }
}
