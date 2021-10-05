<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_start_id')->after('state_pending_task_id')->nullable();
            $table->foreign('user_start_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_end_id')->after('user_start_id')->nullable();
            $table->foreign('user_end_id')->references('id')->on('users');
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
            $table->dropForeign('pending_tasks_user_start_id_foreign');
            $table->dropColumn('user_start_id');
            $table->dropForeign('pending_tasks_user_end_id_foreign');
            $table->dropColumn('user_end_id');
        });
    }
}
