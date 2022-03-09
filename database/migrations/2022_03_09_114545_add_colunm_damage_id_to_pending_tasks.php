<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunmDamageIdToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            $table->foreignId('damage_id')->after('group_task_id')->nullable()->constrained();
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
            $table->dropForeign('pending_tasks_damage_id_foreign');
            $table->dropColumn('damage_id');
        });
    }
}
