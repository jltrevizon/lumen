<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class Task2Seeder extends Seeder
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
                'name' => 'Pasar a disponible',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::ALQUILADO,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Pasar a alquilado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Validar checklist',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Agregar rotulación 1 panel',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Agregar rotulación 2 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Agregar rotulación 3 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Agregar rotulación 4 paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Agregar rotulación 5 o más paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Peritaje',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Repostar combustible',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Personalización del vehículo',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Despersonalización del vehículo',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Defletado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza interior V.O.',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Carga elétrica',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Ozono',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Portaplaca y matrícula',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Cambio / reparación de lunas',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Desmontaje panelado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Desmontaje de baca',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Batería puesta en marcha',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Presión inflado de las ruedas',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Nebulizador',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Botiquín - extintor',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Prelavado',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Movimiento a entrega',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Comprobación de batería',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Limpieza tapicaría',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Gasolina',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Cortes de paneles',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::ALD,
                'sub_state_id' => SubState::PRE_AVAILABLE,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Prueba dinámica',
                'duration' => random_int(1, 40),
            ],
        ];
    }
}
