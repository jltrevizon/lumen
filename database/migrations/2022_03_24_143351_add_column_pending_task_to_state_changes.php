<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPendingTaskToStateChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('state_changes', function (Blueprint $table) {
            $table->foreignId('pending_task_id')->after('vehicle_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('state_changes', function (Blueprint $table) {
            $table->dropForeign('state_change_pending_task_id_foreign');
            $table->dropColumn('pending_task_id');
        });
    }
}
