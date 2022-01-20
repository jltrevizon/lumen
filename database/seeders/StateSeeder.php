<?php

namespace Database\Seeders;

use App\Models\Company;
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
            State::updateOrCreate([
                'id' => $state['id'],
            ], $state);
        }
    }

    public function data(){
        return [
            [
                'id' => 1,
                'name' => 'Disponible',
                'company_id' => Company::ALD,
                'type' => 2
            ],
            [
                'id' => 2,
                'name' => 'Taller',
                'company_id' => Company::ALD
            ],
            [
                'id' => 3,
                'name' => 'Pendiente Venta V.O.',
                'company_id' => Company::ALD
            ],
            [
                'id' => 4,
                'name' => 'No disponible',
                'company_id' => Company::ALD
            ],
            [
                'id' => 5,
                'name' => 'Entregado',
                'company_id' => Company::ALD,
                'type' => 2
            ],
            [
                'id' => 6,
                'name' => 'Pre-disponible',
                'company_id' => Company::ALD
            ]
        ];
    }
}
