<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDamageItToPendingAuthorizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_authorizations', function (Blueprint $table) {
            $table->dropForeign('pending_authorizations_incidence_id_foreign');
            $table->dropColumn('incidence_id');
            $table->foreignId('damage_id')->after('task_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_authorizations', function (Blueprint $table) {
            $table->foreignId('incidence_id')->after('task_id')->constrained();
            $table->dropForeign('pending_authorizations_damage_id_foreign');
            $table->dropColumn('damage_id');
        });
    }
}
