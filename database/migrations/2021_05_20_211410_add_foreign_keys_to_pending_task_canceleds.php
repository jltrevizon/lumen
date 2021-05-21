<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPendingTaskCanceleds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_task_canceleds', function (Blueprint $table) {
            $table->foreign('pending_task_id')->references('id')->on('pending_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_task_canceleds', function (Blueprint $table) {
            $table->dropForeign('pending_tasks_canceleds_pending_task_id_foreign');
        });
    }
}
