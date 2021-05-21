<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('state_pending_task_id')->references('id')->on('state_pending_tasks');
            $table->foreign('group_task_id')->references('id')->on('group_tasks');
            $table->foreign('incidence_id')->references('id')->on('incidences');
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
            $table->dropForeign('pending_tasks_vehicle_id_foreign');
            $table->dropForeign('pending_tasks_task_id_foreign');
            $table->dropForeign('pending_tasks_state_pending_task_id_foreign');
            $table->dropForeign('pending_tasks_group_task_id_foreign');
            $table->dropForeign('pending_tasks_incidence_id_foreign');
        });
    }
}
