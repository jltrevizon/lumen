<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\State;
use Illuminate\Database\Seeder;

class State1Seeder extends Seeder
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
                'name' => 'Pendiente prueba dinámica',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Pendiente checklist inical',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Pendiente de presupuesto',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Pendiente de autorización',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'En reparación',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Pendiente de certificado',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Pendiente de check final',
                'company_id' => Company::INVARAT
            ],
            [
                'name' => 'Finalizado',
                'company_id' => Company::INVARAT
            ]
            ];
    }
}
