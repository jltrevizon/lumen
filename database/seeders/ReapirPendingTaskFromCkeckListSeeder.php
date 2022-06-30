<?php

namespace Database\Seeders;

use App\Models\PendingTask;
use App\Models\QuestionAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ReapirPendingTaskFromCkeckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task_ids = collect(QuestionAnswer::whereNotNull('task_id')->distinct()->get(['task_id']))->map(function ($item){ return $item->task_id;})->toArray();
        $pending_tasks = PendingTask::where('created_from_checklist', 1)
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('group_task_id IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
           // ->where('approved', 1)
            ->whereIn('task_id', $task_ids)
            ->get();
        $pending_task_ids = [];
        foreach ($pending_tasks as $key => $pending_task) {
            # code...
            $question_answer = QuestionAnswer::where('task_id', $pending_task->task_id)
                ->where('questionnaire_id', $pending_task->vehicle->lastQuestionnaire->id)->first();
            if (!is_null($question_answer)) {
                $pending_task->question_answer_id = $question_answer->id;
                $pending_task->save();
                if ($question_answer->response == 0 && $pending_task->approved == 1) {
                    // Log::debug($question_answer->id);
                    $pending_task_ids[] = $pending_task->id;
                }
            }
        }
        if (count($pending_task_ids) > 0) {
            PendingTask::whereIn('id', $pending_task_ids)->update([
                'approved' => 0
            ]);
        }
    }
}
