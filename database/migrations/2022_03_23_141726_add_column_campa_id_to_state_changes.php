<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampaIdToStateChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('state_changes', function (Blueprint $table) {
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
        Schema::table('state_changes', function (Blueprint $table) {
            $table->dropForeign('state_changes_campa_id_foreign');
            $table->dropColumn('campa_id');
        });
    }
}
