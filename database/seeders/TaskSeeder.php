<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = $this->data();
        foreach($tasks as $task){
            Task::create([
                'sub_state_id' => $task['sub_state_id'],
                'type_task_id' => $task['type_task_id'],
                'name' => $task['name'],
                'duration' => $task['duration']
            ]);
        }
    }

    public function data(){
        return [
            [
                'sub_state_id' => 1,
                'type_task_id' => 2,
                'name' => 'Ubicación',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 4,
                'type_task_id' => 2,
                'name' => 'Intervención carrocería',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 3,
                'type_task_id' => 2,
                'name' => 'Intervención mecánica',
                'duration' => 7,
            ],
            [
                'sub_state_id' => 6,
                'type_task_id' => 2,
                'name' => 'ITV',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 2,
                'name' => 'Limpieza simple',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 2,
                'name' => 'Limpieza intermedia',
                'duration' => 6,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 2,
                'name' => 'Limpieza integral',
                'duration' => 8,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 2,
                'name' => 'Limpieza especial',
                'duration' => 12,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 2,
                'name' => 'Quitar rotulación de 1 panel',
                'duration' => 1,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 2,
                'name' => 'Quitar rotulación de 2 paneles',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 2,
                'name' => 'Quitar rotulación de 3 paneles',
                'duration' => 3,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 2,
                'name' => 'Quitar rotulación de 4 paneles',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 2,
                'name' => 'Quitar rotulación de 5 ó más paneles',
                'duration' => 6,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Alineador inercia',
                'duration' => 7,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Baca',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Barras',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Cabestrante',
                'duration' => 1,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Carrozado',
                'duration' => 5,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Cerradura seguridad',
                'duration' => 3,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Enganche',
                'duration' => 8,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Rejilla separadora',
                'duration' => 1,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Rotativo luminoso',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Chapa separadora de carga',
                'duration' => 5,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Vinilo cubre cristales',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Estanterías',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Rotulado',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'Panelados',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 2,
                'type_task_id' => 1,
                'name' => 'Lavado exterior',
                'duration' => 2,
            ]
        ];
    }
}
