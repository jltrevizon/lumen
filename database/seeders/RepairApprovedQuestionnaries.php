<?php

namespace Database\Seeders;

use App\Models\GroupTask;
use App\Models\Questionnaire;
use Illuminate\Database\Seeder;

class RepairApprovedQuestionnaries extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '-1');
        $questionaires = Questionnaire::whereNull('datetime_approved')->get();
        foreach ($questionaires as $key => $questionaire) {
            if ($questionaire->reception_id) {
                if ($questionaire->reception->group_task_id) {
                    if ($questionaire->reception->groupTask->datetime_approved) {
                        $questionaire->datetime_approved = $questionaire->reception->groupTask->datetime_approved;
                        $questionaire->save();
                    }
                }
            }
        }
        $group_tasks = GroupTask::whereNotNull('questionnaire_id')->get();
        foreach ($group_tasks as $key => $group_task) {
            if ($group_task->questionnaire_id) {
                if ($group_task->datetime_approved) {
                    $group_task->questionnaire->datetime_approved = $group_task->datetime_approved;
                    $group_task->questionnaire->save();
                }
            }
        }
    }
}
