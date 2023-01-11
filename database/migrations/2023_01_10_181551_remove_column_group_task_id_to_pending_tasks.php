<?php

use App\Models\PendingTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnGroupTaskIdToPendingTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_tasks', function (Blueprint $table) {
            PendingTask::whereNotNull('group_task_id')->update([
                'group_task_id' => null
            ]);
            $table->dropForeign('pending_tasks_group_task_id_foreign');
            $table->dropColumn('group_task_id');
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
            //
        });
    }
}
