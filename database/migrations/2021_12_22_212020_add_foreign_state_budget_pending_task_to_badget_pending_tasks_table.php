<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignStateBudgetPendingTaskToBadgetPendingTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->foreignId('state_budget_pending_task_id')->after('id')->nullable()->change()->constrained();
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
            $table->dropForeign('state_budget_pending_task_id_foreign');
        });
    }
}
