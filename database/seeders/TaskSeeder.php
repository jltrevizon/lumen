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
                'sub_state_id' => 1,
                'type_task_id' => 2,
                'name' => 'Estancia',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 20,
                'type_task_id' => 2,
                'name' => 'Entrega',
                'duration' => 7,
            ],
            [
                'sub_state_id' => 1,
                'type_task_id' => 2,
                'name' => 'Recogida',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 8,
                'type_task_id' => 1,
                'name' => 'Limpieza simple',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 8,
                'type_task_id' => 1,
                'name' => 'Limpieza intermedia',
                'duration' => 6,
            ],
            [
                'sub_state_id' => 8,
                'type_task_id' => 1,
                'name' => 'Limpieza integral',
                'duration' => 8,
            ],
            [
                'sub_state_id' => 8,
                'type_task_id' => 1,
                'name' => 'Desinfección especial',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 5,
                'type_task_id' => 1,
                'name' => 'ITV',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 3,
                'type_task_id' => 1,
                'name' => 'Montaje de baca completo',
                'duration' => 7,
            ],
            [
                'sub_state_id' => 3,
                'type_task_id' => 1,
                'name' => 'Montaje de baca (sin estructura) o desmontaje de baca',
                'duration' => 9,
            ],
            [
                'sub_state_id' => 3,
                'type_task_id' => 1,
                'name' => 'Trabajos auxiliares: mano de obra (con presupuesto previo)',
                'duration' => 2,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización 1 panel',
                'duration' => 1,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización 2 paneles',
                'duration' => 5,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización 3 paneles',
                'duration' => 3,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización 4 paneles',
                'duration' => 8,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización >= 5 paneles',
                'duration' => 1,
            ],
            [
                'sub_state_id' => 4,
                'type_task_id' => 1,
                'name' => 'Montaje de cerraduras de seguridad',
                'duration' => 4,
            ],
            [
                'sub_state_id' => 4,
                'type_task_id' => 1,
                'name' => 'Pelado total (suelo, laterales, pase de ruedas y puertas)',
                'duration' => 5,
            ],
            [
                'sub_state_id' => 7,
                'type_task_id' => 1,
                'name' => 'Despersonalización 2 paneles',
                'duration' => 2,
            ]
        ];
    }
}
