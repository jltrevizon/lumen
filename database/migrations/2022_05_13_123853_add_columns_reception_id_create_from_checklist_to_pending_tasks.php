<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsReceptionIdCreateFromChecklistToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->foreignId('reception_id')->after('vehicle_id')->nullable()->constrained();
            $table->boolean('created_from_checklist')->after('code_authorization')->nullable();
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
            $table->dropForeign('pending_tasks_reception_id_foreign');
            $table->dropColumn('reception_id');
            $table->dropColumn('created_from_checklist');
        });
    }
}
