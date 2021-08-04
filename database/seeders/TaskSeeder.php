<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\SubState;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TypeTask;

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
                'company_id' => $task['company_id'],
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
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::CAMPA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Ubicación',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::CHAPA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Intervención carrocería',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::MECANICA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Intervención mecánica',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::ITV,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'ITV',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza simple',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza intermedia',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza integral',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza especial',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 1 panel',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 2 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 3 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 4 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 5 ó más paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => 5,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Alineador inercia',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Baca',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Barras',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Cabestrante',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Carrozado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Cerradura seguridad',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Enganche',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rejilla separadora',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rotativo luminoso',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Chapa separadora de carga',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Vinilo cubre cristales',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Estanterías',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rotulado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Panelados',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PENDIENTE_LAVADO,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Lavado exterior',
                'duration' => random_int(1, 40),
            ]
        ];
    }
}
