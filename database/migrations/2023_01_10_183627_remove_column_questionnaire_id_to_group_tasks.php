<?php

use App\Models\GroupTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnQuestionnaireIdToGroupTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tasks', function (Blueprint $table) {
            GroupTask::whereNotNull('questionnaire_id')->update([
                'questionnaire_id' => null
            ]);
            $table->dropForeign('group_tasks_questionnaire_id_foreign');
            $table->dropColumn('questionnaire_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_tasks', function (Blueprint $table) {
            //
        });
    }
}
