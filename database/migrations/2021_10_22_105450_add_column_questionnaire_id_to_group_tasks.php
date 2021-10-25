<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuestionnaireIdToGroupTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tasks', function (Blueprint $table) {
            $table->foreignId('questionnaire_id')->after('vehicle_id')->nullable()->constrained();
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
            $table->dropForeign('group_task_questionnaire_id_foreign');
            $table->dropColumn('questionnaire_id');
        });
    }
}
