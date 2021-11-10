<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSeverityIdToDamages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damages', function (Blueprint $table) {
            $table->foreignId('severity_damage_id')->after('task_id')->nullable()->constrained();
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
            $table->dropForeign('damages_severity_damage_id_foreing');
            $table->dropColumn('severity_damage_id');
        });
    }
}
