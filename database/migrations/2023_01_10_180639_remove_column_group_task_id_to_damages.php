<?php

use App\Models\Damage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnGroupTaskIdToDamages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damages', function (Blueprint $table) {
            Damage::whereNotNull('group_task_id')->update([
                'group_task_id' => null
            ]);
            $table->dropForeign('damages_group_task_id_foreign');
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
        Schema::table('damages', function (Blueprint $table) {
            //
        });
    }
}
