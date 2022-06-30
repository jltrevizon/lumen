<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuestionAnswerIdToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('question_answer_id')->after('reception_id')->nullable();
            $table->foreign('question_answer_id')->references('id')->on('question_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->dropForeign('pending_tasks_question_answer_id_foreign');
            $table->dropColumn('question_answer_id');
        });
    }
}
