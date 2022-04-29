<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRoleIdToBudgetPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->dropForeign('budget_pending_tasks_role_id_foreign');
            $table->dropColumn('role_id');
        });
    }
}
