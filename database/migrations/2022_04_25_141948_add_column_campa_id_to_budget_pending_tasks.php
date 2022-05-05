<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampaIdToBudgetPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_pending_tasks', function (Blueprint $table) {
            $table->foreignId('campa_id')->after('id')->nullable()->constrained();
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
            $table->dropForeign('budget_pending_tasks_campa_id_foreign');
            $table->dropColumn('campa_id');
        });
    }
}
