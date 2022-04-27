<?php

namespace Database\Seeders;

use App\Models\TypeReport;
use Illuminate\Database\Seeder;

class TypeReportSeeder extends Seeder
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
            TypeReport::create([
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Entrada de vehículos'
            ],
            [
                'name' => 'Salidas de vehículos'
            ],
            [
                'name' => 'Stock de vehículos'
            ],
            [
                'name' => 'Estadísticas'
            ]
        ];
    }
}
