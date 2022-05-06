<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCodeAuthorizationToBudgetPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->integer('code_authorization')->after('state_budget_pending_task_id')->nullable();
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
            $table->dropColumn('state_budget_pending_task_id');
        });
    }
}
