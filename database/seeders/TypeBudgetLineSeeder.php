<?php

namespace Database\Seeders;

use App\Models\TypeBudgetLine;
use Illuminate\Database\Seeder;

class TypeBudgetLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = $this->data();
        foreach($types as $type){
            TypeBudgetLine::create([
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Recambio' ],
            [ 'name' => 'Mano de obra' ],
            [ 'name' => 'Pintura' ]
        ];
    }
}
