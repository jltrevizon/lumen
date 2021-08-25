<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class Task1Seeder extends Seeder
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
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_TEST_DINAMIC_INITIAL,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Prueba dinámica inical',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_INITIAL_CHECK,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Checklist Inicial',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_BUDGET,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Presupuesto',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_AUTHORIZATION,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Autorización',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::IN_REPAIR,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Reparación',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_TEST_DINAMIC_FINAL,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Prueba dinámica final',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_TEST_CHECK_FINAL,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Checklist final',
                'duration' => random_int(1, 40),
            ],
            [
                'company_id' => Company::INVARAT,
                'sub_state_id' => SubState::PENDING_CERTIFICATED,
                'type_task_id' => TypeTask::SPECIAL,
                'name' => 'Entregar',
                'duration' => random_int(1, 40),
            ]
        ];
    }
}
