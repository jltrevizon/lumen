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
            State::create([
                'company_id' => $state['company_id'],
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Disponible',
                'company_id' => Company::ALD
            ],
            [
                'name' => 'Taller',
                'company_id' => Company::ALD
            ],
            [
                'name' => 'Pendiente Venta V.O.',
                'company_id' => Company::ALD
            ],
            [
                'name' => 'No disponible',
                'company_id' => Company::ALD
            ],
            [
                'name' => 'Entregado',
                'company_id' => Company::ALD
            ],
            [
                'name' => 'Pre-disponible',
                'company_id' => Company::ALD
            ]
        ];
    }
}
