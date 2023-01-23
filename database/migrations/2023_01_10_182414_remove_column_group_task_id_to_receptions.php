<?php

use App\Models\Reception;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class RemoveColumnGroupTaskIdToReceptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receptions', function (Blueprint $table) {
            //Artisan::call('db:seed', ['--class' => 'RepairApprovedQuestionnaries']);
            Reception::whereNotNull('group_task_id')->update([
                'group_task_id' => null
            ]);
            $table->dropForeign('receptions_group_task_id_foreign');
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
        Schema::table('questionnaires', function (Blueprint $table) {
            //
        });
    }
}
