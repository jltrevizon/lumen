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
            State::updateOrCreate([
                'id' => $state['id'],
            ], $state);
        }
    }

    public function data(){
        return [
            [
                'id' => 7,
                'name' => 'Pendiente prueba dinámica inicial',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 8,
                'name' => 'Pendiente checklist inical',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 9,
                'name' => 'Pendiente de presupuesto',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 10,
                'name' => 'Pendiente de autorización',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 11,
                'name' => 'En reparación',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 12,
                'name' => 'Pendiente prueba dinámica final',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 13,
                'name' => 'Pendiente de check final',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 14,
                'name' => 'Pendiente de certificado',
                'company_id' => Company::INVARAT
            ],
            [
                'id' => 15,
                'name' => 'Finalizado',
                'company_id' => Company::INVARAT
            ]
            ];
    }
}
