<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id');
            $table->foreignId('task_id');
            $table->foreignId('state_pending_task_id')->nullable();
            $table->foreignId('task_group_id');
            $table->foreignId('incidence_id')->nullable();
            $table->foreignId('state_pending_task_id');
            $table->double('duration');
            $table->integer('order');
            $table->dateTime('datetime_pending')->nullable();
            $table->dateTime('datetime_start')->nullable();
            $table->dateTime('datetime_finish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_tasks');
    }
}
