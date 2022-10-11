<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LastChangeStateToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->dateTime('last_change_state')->after('datetime_finish')->nullable();
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
            $table->dropColumn('last_change_state');
        });
    }
}
