<?php

use App\Models\StateChange;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnGroupTaskIdToStateChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('state_changes', function (Blueprint $table) {
            StateChange::whereNotNull('group_task_id')->update([
                'group_task_id' => null
            ]);
            $table->dropForeign('state_changes_group_task_id_foreign');
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
        Schema::table('state_changes', function (Blueprint $table) {
            //
        });
    }
}
