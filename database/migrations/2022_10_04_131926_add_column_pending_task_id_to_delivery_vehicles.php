<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPendingTaskIdToDeliveryVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('pending_task_id')->after('id')->nullable();
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
        Schema::table('delivery_vehicles', function (Blueprint $table) {
            $table->dropForeign('delivery_vehicles_pending_task_id_foreign');
            $table->dropColumn('pending_task_id');
        });
    }
}
