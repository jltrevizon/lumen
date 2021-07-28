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
                'type_task_id' => 2,
                'name' => 'Ubicación',
                'duration' => 9,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::CHAPA,
                'type_task_id' => 2,
                'name' => 'Intervención carrocería',
                'duration' => 9,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::MECANICA,
                'type_task_id' => 2,
                'name' => 'Intervención mecánica',
                'duration' => 7,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::ITV,
                'type_task_id' => 2,
                'name' => 'ITV',
                'duration' => 4,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza simple',
                'duration' => 4,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza intermedia',
                'duration' => 6,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza integral',
                'duration' => 8,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::LIMPIEZA,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza especial',
                'duration' => 12,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 1 panel',
                'duration' => 1,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 2 paneles',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 3 paneles',
                'duration' => 3,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 4 paneles',
                'duration' => 4,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Quitar rotulación de 5 ó más paneles',
                'duration' => 6,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => 5,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Alineador inercia',
                'duration' => 7,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Baca',
                'duration' => 9,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Barras',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Cabestrante',
                'duration' => 1,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Carrozado',
                'duration' => 5,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Cerradura seguridad',
                'duration' => 3,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Enganche',
                'duration' => 8,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rejilla separadora',
                'duration' => 1,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rotativo luminoso',
                'duration' => 4,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Chapa separadora de carga',
                'duration' => 5,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Vinilo cubre cristales',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Estanterías',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Rotulado',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Panelados',
                'duration' => 2,
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PENDIENTE_LAVADO,
                'type_task_id' => TypeTask::ACCESSORY,
                'name' => 'Lavado exterior',
                'duration' => 2,
            ]
        ];
    }
}
