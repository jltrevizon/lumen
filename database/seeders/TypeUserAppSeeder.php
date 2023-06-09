<?php

namespace Database\Seeders;

use App\Models\TypeUserApp;
use Illuminate\Database\Seeder;

class TypeUserAppSeeder extends Seeder
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
            TypeUserApp::create([
                'name' => $type['name'],
                'description' => $type['description']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'Responsable Campa',
                'description' => 'Puede ver todo lo que pasa y mover prioridades de las tareas'
            ],
            [
                'name' => 'Operario Campa',
                'description' => 'Entrada del vehículo, check list, ubicar vehículo en campa y entrega de vehículos'
            ],
            [
                'name' => 'Taller mecánica',
                'description' => null
            ],
            [
                'name' => 'Taller chapa',
                'description' => 'Carrocería'
            ],
            [
                'name' => 'Flotas',
                'description' => 'Rotulación y accesorios: indican quien realiza la tarea, si Taller Chapa, Operario Campa o Taller Externo (en este caso, el operario da la salida del vehículo)'
            ],
            [
                'name' => 'Lavado',
                'description' => null
            ],
            [
                'name' => 'Lunas',
                'description' => null
            ],
            [
                'name' => 'Administrativo taller mecánica',
                'description' => 'Puede mirar las tareas pendientes de los vehículos y subir presupuestos para las tareas de taller de mecánica'
            ],
            [
                'name' => 'Administrativo taller carrocería',
                'description' => 'Puede mirar las tareas pendientes de los vehículos y subir presupuestos para las tareas de taller carrocería'
            ]
        ];
    }
}
