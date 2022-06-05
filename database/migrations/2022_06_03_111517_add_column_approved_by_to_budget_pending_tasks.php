<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApprovedByToBudgetPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->after('url')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->unsignedBigInteger('declined_by')->after('approved_by')->nullable();
            $table->foreign('declined_by')->references('id')->on('users');
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
            $table->dropForeign('budget_pending_tasks_approved_by_foreign');
            $table->dropColumn('approved_by');
            $table->dropForeign('budged_pending_tasks_declined_by_foreign');
            $table->dropColumn('declined_by');
        });
    }
}
