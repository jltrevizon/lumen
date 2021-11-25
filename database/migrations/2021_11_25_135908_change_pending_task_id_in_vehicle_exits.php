<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePendingTaskIdInVehicleExits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_exits', function (Blueprint $table) {
            $table->foreignId('pending_task_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_exits', function (Blueprint $table) {
            $table->foreignId('pending_task_id')->nullable(true)->change();
        });
    }
}
