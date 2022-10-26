<?php

namespace Database\Seeders\Invarat;

use App\Models\Company;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class TaskBudgetExtraInvaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Task::create(array(
            "company_id" => Company::INVARAT,
            "sub_state_id" => SubState::PENDING_BUDGET,
            "type_task_id" => TypeTask::SPECIAL,
            "need_authorization" => 1,
            "name" => "Presupuesto Extras",
            "duration" => "6",
        ));
    }
}
