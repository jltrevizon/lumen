<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQuestionAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_answers', function (Blueprint $table) {
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_answers', function (Blueprint $table) {
            $table->dropForeign('question_answers_questionnaire_id_foreign');
            $table->dropForeign('question_answers_question_id_foreign');
        });
    }
}
