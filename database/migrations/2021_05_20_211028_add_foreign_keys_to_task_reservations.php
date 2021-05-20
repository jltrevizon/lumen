<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTaskReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_reservations', function (Blueprint $table) {
            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_reservations', function (Blueprint $table) {
            $table->dropForeign('task_reservations_request_id_foreign');
            $table->dropForeign('task_reservations_task_id_foreign');
            $table->dropForeign('task_reservations_vehicle_id_foreign');

        });
    }
}
